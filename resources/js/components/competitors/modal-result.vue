<template>
    <div class="modal fade" :id="'modal-competitior-result'+this.competitor_id" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" action="">
                        <input type="number" style="display: none" class="form-control" name="competition_id" value="">
                        <input type="number" class="form-control" name="count_winner" placeholder="Количество побед">
                        <input type="number" class="form-control" name="place" placeholder="Занятое место">
                        <div class="modal-footer justify-content-between">
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal-result",
    data() {
        return {

        }
    },
    props: [
        'competitor_id'
    ],
}
</script>

<style scoped>

</style>
