<template>
    <input type="text"class="form-control" v-mask="'##.##.####'" v-model="myInputModel" name="date_of_birth">
</template>
<script>
import VueMask from 'v-mask'
Vue.use(VueMask)
export default {
    data: () => ({
        myInputModel: ''
    })
}
</script>

<style scoped>

</style>
