<template>
    <form @submit.prevent="submitStep" :id="id" :action="action" :method="method">
        <slot name="header" />
        <div v-for="(step, index) in steps" :key="index" :id="'step'+(index+1)" v-show="activeStepIndex===index"
            class="vue-form-step">

            <slot :name="'step'+(index+1)" />

        </div>
        <slot name="footer">
            <button type="submit">Next</button>
        </slot>
    </form>
</template>
<script lang="ts">
import { defineComponent } from 'vue';


export default defineComponent({

    props: ['steps', 'id', 'action', 'method'],
    data() {
        return {
            activeStepIndex: 0,
        };
    },
    methods: {
        submitStep() {
            if (!this.steps[this.activeStepIndex].step_valid) {
                this.$emit('validateStep', this.activeStepIndex);
                return false;
            }
            let isLastStep = (this.activeStepIndex == (this.steps.length - 1));
            // console.log(isLastStep);
            // console.log(this.steps.length);
            // console.log(this.activeStepIndex);

            if (isLastStep && this.action) {
                // console.log('data');

                this.submitForm();
                return true;
            }
            if (isLastStep) {
                this.$emit('onComplete');
                // console.log('data');

                return true;
            }
            // console.log('data');

            this.activeStepIndex++;
            while (this.steps[this.activeStepIndex].step_skip === true) {
                this.activeStepIndex++;
            }
        },
        submitForm() {
            document.getElementById(this.id).submit();
        }
    }
})
</script>