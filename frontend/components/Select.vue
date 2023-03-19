<script lang="ts">
export default {
  inheritAttrs: false,
};
</script>

<script setup lang="ts">
type Props = {
  modelValue?: string[] | number[] | string;
  errors?: string[] | string;
  options?: {label: string, value: any}[];
};

const props = defineProps<Props>();
defineEmits(["update:modelValue"]);

const renderedErrors = computed(() =>
    Array.isArray(props.errors)
        ? props.errors
        : props.errors
            ? [props.errors]
            : []
);
</script>

<template>
  <div>
    <client-only>
      <el-select :model-value="modelValue" v-bind="$attrs" @change="(value) => $emit('update:modelValue', value)" class="shadow-1 shadow-black">
        <el-option
            v-for="option in options"
            :key="option.value"
            :label="option.label"
            :value="option.value"
        />
      </el-select>
    </client-only>

    <!-- Validation Errors -->
    <ul v-if="renderedErrors?.length > 0" class="mt-3 text-sm text-red-600">
      <li v-for="error in renderedErrors" :key="error">{{ error }}</li>
    </ul>
  </div>
</template>
