<template>
    <div class="modal fade" :id="'modal-competitior-result'+this.competitor_id" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                        <input type="number" class="form-control"
                               v-model="count_winner"
                               placeholder="Количество побед">
                        <input type="number" class="form-control"
                               v-model="place"
                               placeholder="Занятое место">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="print_certificate" v-model="print_certificate">
                            <label class="form-check-label" for="print_certificate">Печать грамоты</label>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                            <button data-dismiss="modal" @click="setResult" class="btn btn-primary">Отправить</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import eventEmitter from 'tiny-emitter/instance'

export default {
    name: "modal-result",
    data() {
        return {
            count_winner: null,
            place: null,
            print_certificate: true
        }
    },
    props: [
        'competition_id',
        'competitor_id'
    ],
    methods: {
        setResult () {
            axios.post(`/api/competitors-update-result/${this.competitor_id}`, {
                params: {
                    competition_id: this.competition_id,
                    count_winner: this.count_winner,
                    place: this.place
                }
            })
                .then((response) => {
                    this.$emit('result', {
                        count_winner: this.count_winner,
                        place: this.place,
                        print_certificate: this.print_certificate,
                        competitor_id: this.competitor_id,
                        competition_id: this.competition_id,
                    })
                })
        }
    }
}
</script>

<style scoped>

</style>
