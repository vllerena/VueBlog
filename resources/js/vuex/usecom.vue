<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>I will show how all other components react to changes</h1>
                <h2>Current state of counter is: {{getCounter}}</h2>
                <hr>
                <div>
                    <com-a></com-a>
                </div>
                <div>
                    <com-b></com-b>
                </div>
                <div>
                    <com-c></com-c>
                </div>
                <Button type="info" @click="changeCounter">Change the state of the counter</Button>
            </div>
        </div>
    </div>
</template>

<script>
import comA from "./comA";
import comB from "./comB";
import comC from "./comC";
import {mapGetters, mapActions} from 'vuex'
export default {
    name: "usecom",
    data(){
        return {

        }
    },
    computed: {
        ...mapGetters(['getCounter'])
    },
    methods: {
        ...mapActions([
            'changeCounterAction'
        ]),
        changeCounter(){
            this.$store.dispatch('changeCounterAction', 1)
            // this.$store.commit('changeTheCounter', 1)
        }
    },
    created() {
    },
    components: {
        comA,
        comB,
        comC
    },
    watch: {
        getCounter(value){
            console.log('Counter is changing: ', value)
        }
    }
}
</script>

<style scoped>

</style>
