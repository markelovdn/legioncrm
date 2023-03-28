<template>
    <div>
        <div class="card card-primary collapsed-card" v-for = "competitor in competitors">
            <div class="card-header">
                <span><img class="direct-chat-img" :src="competitor.athlete.photo" alt="message user image"></span>
                <h3 class="card-title">{{ competitor.athlete.user.secondname }} {{ competitor.athlete.user.firstname }} {{ competitor.athlete.user.patronymic }}</h3>

                <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" :data-target="'#modal-competitior-result'+competitor.id">
                                внести результаты</span>

                <!--        modal result-->
                <modal-result :id="'modal-competitior-result'+competitor.id"></modal-result>
                <br>

                <i class="fas fa-male"></i>
                <i class="fas fa-female"></i>
                - Дети 10-11 лет Группа А (до 7 гыпа),
                Тренер: Иванов И.И.
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <b>Дата рождения: </b> 10.08.1983<br>
                <b>Вес: </b>34<br>
                <b>Техническая квалификация: </b>
                <span>нет</span><br>
                <b>Спортивная квалификация: </b>нет<br>
            </div>

            <div class="card-footer">
                <div class="row row-cols-2">
                    <div class="col text-left">
                        <form method="GET" action="">
                            <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-cog"></i></button>
                        </form>
                        <div class="col text-left">
                            <a target="_blank" href=""><i class="fas fa-file-contract"></i></a>
                        </div>

                        <form method="POST" action="">
                            <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-tv"></i></button>
                        </form>

                    </div>
                    <div class="col text-right">
                        <form method="POST" action="">
                            <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "competitors-list",
    data() {
        return {
            competitors: []
        }
    },
    props: [
        'competition_id'
    ],

    methods: {
        getCompetitors() {
            axios.get(`/api/competitors-api/`+this.competition_id)
                .then((response) => {
                    console.log(response.data)
                    this.competitors = response.data
                })
        }
    },
    mounted() {
        this.getCompetitors();
    }
}
</script>

<style scoped>

</style>
