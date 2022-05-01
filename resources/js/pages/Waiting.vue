<template>
    <Layout>
        <div class="flex justify-center">
            <div class="bg-white rounded-md p-4 shadow w-1/2 mt-28">
                <div class="flex justify-center">
                    <h1 class="text-center font-medium text-lg">{{ $t('game.waiting.title')}}</h1>
                </div>
                <div class="flex justify-center">
                    <p class="text-center text-gray-600 text-sm">{{ $t('game.waiting.description')}}</p>
                </div>
                <div class="flex justify-center mt-2">
                    <p @click="copy" class="font-medium text-lg">{{ route('games.join', game) }}</p>
                </div>
                <div class="flex justify-center mt-2" v-if="copied">
                    <p class="text-center text-green-600 text-sm">{{ $t('game.waiting.copied')}}</p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Layout";
export default {
    name: "Waiting",
    components: {Layout},
    props: {
        game: Object,
    },
    data() {
        return {
            copied: false,
        };
    },
    methods: {
        copy() {
            navigator.clipboard.writeText(route('games.join', this.game));
            this.copied = true
            setTimeout(() => {
                this.copied = false
            }, 2000);
        }
    },
    mounted() {
        Echo.private(`games.${this.game.id}`)
            .listen('GameStartedEvent', (e) => {
                console.log("Game started!")
                this.$inertia.reload();
            })
            .listen('GameUpdatedEvent', (e) => {
                console.log("Event received", e);
            })
    }
}
</script>

<style scoped>

</style>
