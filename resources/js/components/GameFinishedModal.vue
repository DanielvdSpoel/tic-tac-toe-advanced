<template>
    <TransitionRoot as="template" :show="true">
        <Dialog as="div" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                        <div>
                            <div v-if="status === 'draw'" class="mt-3 text-center sm:mt-5">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">{{ $t('game.finished.draw.title') }}</DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">{{ $t('game.finished.draw.description') }}</p>
                                </div>
                            </div>
                            <div v-else-if="status === 'win' && authUserIsWinning" class="mt-3 text-center sm:mt-5">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">{{ $t('game.finished.win.you.title') }}</DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">{{ $t('game.finished.win.you.description') }}</p>
                                </div>
                            </div>
                            <div v-else class="mt-3 text-center sm:mt-5">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">{{ $t('game.finished.win.opponent.title') }}</DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">{{ $t('game.finished.win.opponent.description') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <InertiaLink as="button" :href="route('games.create')"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                                {{ $t('game.finished.restart')}}
                            </InertiaLink>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";

export default {
    name: "GamefinishededModal",
    props: {
        status: String,
        winner: Object,
    },
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },
    computed: {
        authUserIsWinning() {
          return this.$page.props.user.id === this.winner.id
        },
    }
}
</script>

<style scoped>

</style>
