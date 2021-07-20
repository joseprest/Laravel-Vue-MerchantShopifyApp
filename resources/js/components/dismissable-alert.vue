<template>
    <b-alert :show="dismissCountDown"
             v-if="text"
             :variant="type"
             dismissible
             @dismissed="dismissed"
             @dismiss-count-down="countDownChanged">
        {{ text }}
    </b-alert>
</template>

<script>
    export default {
        props: {
            text: {
                default: '',
                type: String
            },
            type: {
                default: 'success',
                type: String
            },
            duration: {
                default: 5,
                type: Number
            }
        },
        data() {
            return {
               dismissCountDown: 0,
            }
        },
        methods: {
            countDownChanged(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
            },
            dismissed() {
                this.dismissCountdown = 0
            }
        }
    }
</script>