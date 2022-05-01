<template>
    <Layout>
        <GameFinishedModal
            v-if="finishedModel.isOpen"
            :winner="finishedModel.winner"
            :status="finishedModel.status"
        />
        <div v-if="gameLoaded" class="md:flex gap-8 mx-4 h-[88vh]">
            <div class="w-full md:h-full my-4 flex justify-center items-center">
                <div class="w-full max-w-xl bg-indigo-600">
                    <ul class="grid grid-cols-3 gap-1 aspect-square">
                        <li v-for="position in positions" :key="position.id" class="bg-gray-100 flex justify-center items-center aspect-square" :class="{
                            'hover:bg-gray-200': placingPiece !== null && isPossibleMove(position),
                            'bg-gray-300': isPossibleMove(position),
                        }" @click="placePiece(position)">

                            <GamePiece v-if="position.piece" :selectable="false" :piece="position.piece" :color="getPlayerColor(position.piece.player_id)"/>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full md:h-full my-4">
                <div v-for="player in players" :key="player.id">
                    <h3 v-if="authPlayer.id === player.id" class="font-medium text-gray-700">{{ $t('game.play.player_pieces')}}</h3>
                    <h3 v-else class="font-medium text-gray-700">{{ $t('game.play.opponent_pieces')}}</h3>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <GamePiece v-for="piece in player.availablePieces" :key="piece.id" :color="player.color"
                            :selectable="authPlayer.id === player.id ? canPlacePiece : false"
                                   :piece="piece" :selectedPiece="placingPiece" @selectPiece="placingPiece = piece"/>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="flex justify-center mt-2">
                <h1 class="text-center font-semibold text-lg">{{ $t('game.play.loading')}}</h1>
            </div>
            <div class="flex items-center justify-center mt-2">
                <svg class="w-16 h-16 mr-2 text-gray-200 animate-spin fill-indigo-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Layout";
import GamePiece from "../components/GamePiece";
import GameFinishedModal from "../components/GameFinishedModal";
export default {
    name: "Play",
    components: {GameFinishedModal, GamePiece, Layout},
    props: {
        game: Object
    },
    data() {
        return {
            finishedModel: {
                isOpen: false,
                status: null,
                winner: null,
            },
            placingPiece: null,
            gameLoaded: false,
            positions: [],
            players: [],
            canPlacePiece: false,
        }
    },
    mounted() {
        console.log('mounted')
        console.log(this.authPlayer)
        Echo.private(`games.${this.game.id}`)
            .listen('GameUpdatedEvent', (e) => {
                console.log('updated')
                console.log(e)
                this.gameLoaded = true
                this.positions = e.game.positions
                this.players = e.game.players
                this.canPlacePiece = e.game.playing_player_id === this.authPlayer.id
            })
            .listen('GameFinishedEvent', (e) => {
                console.log('finished')
                console.log(e)
                this.finishedModel.isOpen = true
                this.finishedModel.status = e.status
                this.finishedModel.winner = e.winner
            });

        if (this.game.positions.length !== 0) {
            this.gameLoaded = true
            this.positions = this.game.positions
            this.players = this.game.players
            this.canPlacePiece = this.game.playing_player_id === this.authPlayer.id
        }
    },
    computed: {
        authPlayer() {
            return this.$page.props.user
        }
    },
    methods: {
        getPlayerColor(id) {
            return this.players.find(player => player.id === id).color
        },
        placePiece(position) {
            if (!this.isPossibleMove(position)) {
                return
            }
            this.$inertia.patch(route('gamePositions.update', position), {
                piece_id: this.placingPiece.id
            }, {
                onSuccess: page => {
                    this.placingPiece = null
                },
            })
        },
        isPossibleMove(position) {
            if (!this.placingPiece) return false;
            if (position.piece) {
                return position.piece.value < this.placingPiece.value
            } else {
                return true
            }
        }
    }
}
</script>

<style scoped>

</style>
