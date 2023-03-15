<template>
    <div class="row">
        <div class="col-auto mr-auto">
            <button  data-toggle="modal" data-target="#modal-vue" class="btn btn-primary"></button>
            <change-status-modal></change-status-modal>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
