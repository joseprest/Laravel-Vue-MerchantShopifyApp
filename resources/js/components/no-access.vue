<template>
    <div class="card permissions-box" :class="plan">
        <span class="px-4 pb-3" :class="{'loading': loading}">
            <div class="border-bottom">
                <h5 class="bold f-s-18 m-b-15">
                    <span v-text="title"></span>
                </h5>
            </div>
            <div class="mt-4">
                <img class="mb-3" :src="'/images/permissions/'+icon" height="80">

                <p class="text-center">
                    <span v-text="desc"></span>
                </p>
                <a class="btn btn-success" :href="url">
                    Upgrade <span v-if="plan">to</span> <span v-text="plan"></span>
                </a>
            </div>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                default: 'No Access!',
                type: String
            },
            icon: {
                default: 'integrations.png',
                type: String
            },
            desc: {
                default: '',
                type: String
            },
            plan: {
                default: '',
                type: String
            },
            url: {
                default: '/upgrade',
                type: String
            },
            loading: {
                default: false,
                type: [Boolean]
            }
        }
    }
</script>

<style lang="scss">
    .permissions-box {
        text-align: center;
        padding: 20px 0 !important;
    }
</style>