<template>
    <Layout>
        <div class="flex justify-center">
            <div class="bg-white rounded-md p-4 shadow w-1/3 mt-28">
                <div class="flex justify-center">
                    <h1 class="text-center font-medium text-lg">{{ $t('game.home.title')}}</h1>
                </div>
                <div class="flex justify-center">
                    <p class="text-center text-gray-600 text-sm">{{ $t('game.home.description')}}</p>
                </div>
                <form @submit.prevent="form.post(route('games.store'))">
                    <div class="flex justify-center">
                        <InputField
                            name="name"
                            type="text"
                            :label="$t('labels.name')"
                            v-model="form.name"
                            :centered="true"
                        />
                    </div>
                    <div>
                        <BaseField
                            name="color"
                            :label="$t('labels.color')"
                            :centered="true"
                        >
                            <ul class="flex justify-center gap-2 mt-2">
                                <li @click="form.color = 'blue'" :class="{'border-2 border-indigo-600': form.color === 'blue'}"
                                    class="bg-white rounded-md shadow py-2 px-4">
                                    <div class="flex justify-center">
                                        <p class="text-sm gray-500 select-none">{{ $t('labels.blue')}}</p>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="bg-blue-600 h-4 w-8"></div>
                                    </div>
                                </li>
                                <li @click="form.color = 'red'" :class="{'border-2 border-indigo-600': form.color === 'red'}"
                                    class="bg-white rounded-md shadow py-2 px-4">
                                    <div class="flex justify-center">
                                        <p class="text-sm gray-500 select-none">{{ $t('labels.red')}}</p>
                                    </div>
                                    <div class="flex justify-center">
                                        <div class="bg-red-600 h-4 w-8"></div>
                                    </div>
                                </li>
                            </ul>

                        </BaseField>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" :disabled="form.processing" class="btn btn-indigo mt-4">{{ $t('game.home.button')}}</button>
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
    name: "Home",
    components: {BaseField, InputField, Layout},
    data() {
        return {
            form: this.$inertia.form({
                name: "",
                color: ['red', 'blue'][Math.floor(Math.random() * 2)],
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
