<template>
    <Layout>
        <div class="flex justify-center">
            <div class="bg-white rounded-md p-4 shadow w-1/3 mt-28">
                <div class="flex justify-center">
                    <h1 class="text-center font-medium text-lg">{{ $t('game.join.title') }}</h1>
                </div>
                <div class="flex justify-center">
                    <p class="text-center text-gray-600 text-sm">{{ $t('game.join.description') }}</p>
                </div>
                <form @submit.prevent="form.post(route('games.join', game))">
                    <div class="flex justify-center">
                        <InputField
                            name="name"
                            type="text"
                            :label="$t('labels.name')"
                            v-model="form.name"
                            :centered="true"
                        />
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" :disabled="form.processing" class="btn btn-indigo mt-4">
                            {{ $t('game.home.button') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>

<script>
import BaseField from "../components/Fields/BaseField";

const names = [
    'AmazonX',
    'System Debt',
    'Snap',
    'Clink_in_the_Armor',
    'Jakku',
    'Red Reaper',
    'Cobra',
    'Cutthroat',
    'Sweet Angel 93',
    'Rattler',
    'Mad Cats',
    'Miserables',
    'Karen66',
    'No_Pain_No_Gain',
    'Life of Pie',
    'Tragedy',
    'Friction',
    'Rick N Morty',
    'Riptide',
    'Crank N Bolt',
    'BroCode',
    'Skinny',
    'Mitaka',
    'Gunner',
    'Doomsday',
    'Troop N Treasure',
    'Lady Bug',
    'Slashers',
    'Drogon',
    'Viserion',
    'Last Life',
    'Simpsons',
    'Dark Sword',
    'Daylight',
    'Dandelions',
    'Myracah',
    'Luna',
    'Sanctimonious Gamer',
    'Sasquatch',
    'Insidious',
]

import Layout from "../Layout";
import InputField from "../components/Fields/InputField";

export default {
    name: "Join",
    components: {BaseField, InputField, Layout},
    props: {
        game: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                name: "",
            }),
        };
    },
    mounted() {
        this.form.name = names[Math.floor(Math.random() * names.length)];
    }
}
</script>

<style scoped>

</style>
