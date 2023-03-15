<template>
        <div class="modal fade" id="modal-vue" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                            <button type="submit" class="btn btn-success" @click="count++">{{ count }}<i class="fas fa-plus"></i></button>
                            <button type="submit" class="btn btn-danger" @click="count--">{{ count }}<i class="fas fa-minus"></i></button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                count: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
