<template>
    <div v-if="color === 'red'"
        class="rounded-full border-4 border-red-600 flex justify-center items-center" :class="styling + (selectable ? ' hover:bg-red-100' : '') ">
        <span class="font-semibold text-red-600">{{ number }}</span>
    </div>
    <div v-if="color === 'blue'"
         class="rounded-full border-4 border-blue-600 flex justify-center items-center" :class="styling + (selectable ? ' hover:bg-blue-100' : '')">
        <span class="font-semibold text-blue-600">{{ number }}</span>
    </div>
</template>

<script>
export default {
    name: "GamePiece",
    props: {
        selectable: false,
        color: String,
        number: Number,
    },
    computed: {
        styling() {
            switch(this.number) {
                case 1:
                    return 'w-8 h-8 text-lg'
                case 2:
                    return 'h-14 w-14 text-3xl'

                case 3:
                    return 'h-20 w-20 text-3xl'
            }
        }
    }
}
</script>

<style scoped>

</style>
