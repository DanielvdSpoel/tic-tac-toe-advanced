<template>
    <div class="relative flex items-start">
        <div class="flex items-center h-5 mt-0.5">
            <input :id="name" :aria-describedby="label + '-description'" :name="label" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                   v-model="modelValue" :ref="name"
            />
        </div>
        <div class="ml-2 text-sm">
            <label :for="name" class="font-medium text-gray-700">{{ label }}</label>
            <p v-if="description" class="text-sm text-gray-500 max-w-md">{{ description }}</p>
        </div>

    </div>
</template>

<script>
export default {
    name: "CheckBoxField",
    props: {
        modelValue: Boolean,
        form: Object,
        name: String,
        label: String,
        placeholder: String,
        description: String,
        required: Boolean,
        default: Boolean,
        disabled: Boolean,
    },
    watch: {
        modelValue: function (value) {
            this.$emit('update:modelValue', value);
        },
    },
    computed: {
        error() {
            if (this.form) {
                if (this.form.errors[this.name]) {
                    return this.form.errors[this.name];
                }
                return null
            }
            if (this.$page.props.errors[this.name]) {
                return this.$page.props.errors[this.name]
            }
            return null
        }
    }
}
</script>
