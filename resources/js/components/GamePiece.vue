<template>
    <div v-if="color === 'red'" @click="selectPiece"
        class="rounded-full border-4 border-red-600 flex justify-center items-center" :class="{
          'hover:bg-red-100': selectable,
          'bg-red-200': isSelected,
          'h-20 w-20 text-3xl': piece.value === 3,
          'h-14 w-14 text-3xl': piece.value === 2,
          'w-8 h-8 text-lg': piece.value === 1,
        }">
        <span class="font-semibold text-red-600 select-none">{{ piece.value }}</span>
    </div>
    <div v-if="color === 'blue'" @click="selectPiece"
         class="rounded-full border-4 border-blue-600 flex justify-center items-center" :class="{
          'hover:bg-blue-100': selectable,
          'bg-blue-200': isSelected,
          'h-20 w-20 text-3xl': piece.value === 3,
          'h-14 w-14 text-3xl': piece.value === 2,
          'w-8 h-8 text-lg': piece.value === 1,
        }">
        <span class="font-semibold text-blue-600 select-none">{{ piece.value }}</span>
    </div>
</template>

<script>
export default {
    name: "GamePiece",
    props: {
        selectedPiece: Object,
        selectable: Boolean,
        piece: Object,
        color: String,
    },
    emits: ["selectPiece"],

    methods: {
        selectPiece() {
            if (this.selectable) {
                this.$emit('selectPiece', this.piece);
            }
        },
    },
    computed: {
        isSelected() {

            return this.selectedPiece && this.selectedPiece.id === this.piece.id
        },
    }
}
</script>

<style scoped>

</style>
