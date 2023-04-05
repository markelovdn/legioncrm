<template>
    <div class="competitors-list">
        <div v-if="loading" class="loading">
            Загрузка...
        </div>

        <div class="card card-primary collapsed-card" v-for = "competitor in filteredList">
            <div class="card-header">
                <span><img class="direct-chat-img" :src="competitor.athlete.photo" alt="message user image"></span>
                <div class="card-title ml-2 mt-2">{{ competitor.athlete.user.secondname }} {{ competitor.athlete.user.firstname }} {{ competitor.athlete.user.patronymic }}</div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <i class="fas fa-male" v-if="competitor.athlete.gender == male"></i>
                <i class="fas fa-female" v-else></i>
                <br><b>Дата рождения: </b> {{ competitor.athlete.user.date_of_birth }}<br>
                <b>Вес: </b>{{ competitor.weight }}<br>
                <b>Техническая квалификация: </b>
                <span>нет,</span> {{ competitor.tehkvalgroup.title }}<br>
                <b>Спортивная квалификация: </b>нет<br>
                <b>Возрастная группа: </b> {{ competitor.agecategory.title }}<br>
                <b>Тренер: </b> <span v-for="coach in competitor.athlete.coaches" v-if="coach.pivot.coach_type === 4">
                    <!-- TODO: как избавиться от магической 4-->
                    {{coach.user.secondname}} {{coach.user.firstname}} {{coach.user.patronymic}}
                </span>
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
                            <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" :data-target="'#modal-competitior-result'+competitor.id">
                                внести результаты</span>
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
import { eventEmitter } from './../../app'
export default {
    name: "competitors-list",
    data() {
        return {
            loading: false,
            search: '',
            competitors: [],
            male: 1,
            female: 2,
            age_category_id: null
        }
    },
    props: [
        'competition_id',
    ],
    created() {
        this.getCompetitors()
    },
    computed: {
      filteredList () {
          return this.competitors.filter(elem => {
                  return elem.athlete.user.secondname.toLowerCase().includes(this.search.toLowerCase())
          });
      }
    },
    methods: {
        getCompetitors() {
            this.loading = true
            axios.get(`/api/competitors-api/${this.competition_id}/${this.coach_id}/${this.age_category_id}`)
                .then((response) => {
                    this.competitors = response.data
                    this.loading = false
                })
        }
    },
    mounted() {
        eventEmitter.$on('getCoachId', coach_id => {
            this.coach_id = coach_id
            this.getCompetitors();
        })
        eventEmitter.$on('getSearchString', search => {
            this.search = search
        })
        eventEmitter.$on('getAgeCategoryId', age_category_id => {
            this.age_category_id = age_category_id
            this.getCompetitors();
            console.log(this.age_category_id)
        })


    }
}
</script>

<style scoped>
.competitors-list {
    padding: 0 0.5rem
}
</style>
