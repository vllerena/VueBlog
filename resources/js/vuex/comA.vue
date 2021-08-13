<template>
    <div>
        <h1>I'm component A and the counter is: {{getCounter}}</h1>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: "comA",
    computed: {
        ...mapGetters(['getCounter'])
    },
}
</script>

<style scoped>

</style>
