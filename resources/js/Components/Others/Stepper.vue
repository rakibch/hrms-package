<script setup lang="ts">
defineProps<{
    steps: { title: string }[];
}>();

const emits = defineEmits<{
    (e: 'on-step-changed', step: number): void;
}>();

const model = defineModel<number>({
    default: 1,
});

function changeStep(step: number) {
    model.value = step;
    emits('on-step-changed', step);
}
</script>

<template>
    <div class="timeline">
        <div
            v-for="(step, index) in steps"
            :key="index + 1"
            :class="[
                'step cursor-pointer',
                { 'step-active': index + 1 === model },
            ]"
            @click="changeStep(index + 1)"
        >
            <div class="step-container">
                <div class="step-number bg-primary-600">
                    <span>{{ index + 1 }}</span>
                </div>
                <div class="step-title">{{ step.title }}</div>
            </div>
            <div v-if="index + 1 < steps.length" class="step-line"></div>
        </div>
    </div>
</template>

<style scoped>
.timeline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    width: 100%;
    max-width: 800px;
    margin: auto;
}

.step {
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: center;
    position: relative;
    text-align: center;
}

.step-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 36px;
    height: 36px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 14px;
    background: transparent;
    border: #eaecf0 2px solid;
    color: #eaecf0;
    font-weight: bold;
    position: relative;
    z-index: 1;
    transition:
        background 0.3s,
        color 0.3s;
}

.step-title {
    margin-top: 8px;
    color: #4b5563;
    font-size: 14px;
    font-weight: 500;
}

.step-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    top: 30%;
    left: calc(50% + 18px);
    right: calc(-50% + 18px);
    z-index: 0;
}

.step-active .step-number {
    background: #4b5563;
    color: #fff;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
}

.step-completed .step-number {
    background: theme('colors.primary.600');
    color: #fff;
}

.step-completed .step-line {
    background: theme('colors.primary.500');
}
</style>
