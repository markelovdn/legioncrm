<template>
    <div class="competitors-list">
        <div v-if="loading" class="spinner-border text-dark" role="status">
        </div>

        <div v-if="filteredList.length === 0 & !loading" class="loading">
            Нет спортсменов по данным параметрам...
        </div>

        <p v-if="errors.length">
            <b>Пожалуйста исправьте указанные ошибки:</b>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
        </p>

        <div v-if="!loading" class="card card-primary collapsed-card" v-for = "competitor in filteredList" :key="competitor.id">
            <div class="card-header">
                <span><img class="direct-chat-img" :src="competitor.athlete.photo" alt="message user image"></span>
                <div class="card-title ml-2 mt-2">{{ competitor.athlete.user.secondname }} {{ competitor.athlete.user.firstname }} {{ competitor.athlete.user.patronymic }}
                    (<span v-for="coach in competitor.athlete.coaches" v-if="coach.pivot.coach_type === 4">
                    <!-- TODO: как избавиться от магической 4-->
                    {{coach.user.secondname}} {{coach.user.firstname | formatName}} {{coach.user.patronymic | formatName}}
                </span>)
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <span v-if="competitor.athlete.gender === male"><i class="fas fa-male"></i></span>
                <span v-else><i class="fas fa-female"></i></span>
                <br><b>Дата рождения: </b> {{ competitor.athlete.user.date_of_birth | formatDate}}<br>
                <b>Вес: </b>{{ competitor.weight }}<br>
                <b>Весовая категория: </b>{{ competitor.weightcategory.title }}<br>
                <b>Техническая квалификация: </b>
                <span>{{ competitor.athlete.tehkval.reduce((acc, curr) => acc.id > curr.id ? acc : curr).title }}</span><br>
                <b>Спортивная квалификация: </b>
                <span v-if="competitor.athlete.sportkval.length > 0">{{ competitor.athlete.sportkval.reduce((acc, curr) => acc.id > curr.id ? acc : curr).short_title }}</span><br>
                <b>Тренер: </b>
                <span v-for="coach in competitor.athlete.coaches" v-if="coach.pivot.coach_type === 4">
                    <!-- TODO: как избавиться от магической 4-->
                    {{coach.user.secondname}} {{coach.user.firstname}} {{coach.user.patronymic}}
                </span><br>
                <b>Возрастная группа: </b> {{ competitor.agecategory.title }}<br>
                <b>Техническая группа: </b> {{ competitor.tehkvalgroup.title }}<br>
                <b>Количество побед: </b><span>{{ competitor.count_winner }}</span> <br>
                <b>Занятое место: </b><span>{{ competitor.place }}</span><br>
                    <span class="badge badge-success"
                          @click="getCompetitorId(competitor.id)"
                          data-toggle="modal"
                          style="cursor: pointer"
                          :data-target="'#modal-competitior-result'+competitor.id"
                          v-if="is_owner">внести результаты
                    </span>
            </div>
            <div class="card-footer">
                <div class="row row-cols-2">
                    <div class="col text-left">
                            <button class="btn btn-primary"
                                    @click="getCompetitor(competitor.id)"
                                    :data-target="'#modal-competitor-edit'+competitor.id"
                                    data-toggle="modal"
                                    v-if="coach_id"><i class="fas fa-edit"></i></button>

                            <button type="submit" class="btn btn-danger" v-if="user.referee != null"><i class="fas fa-tv"></i></button>
                    </div>
                    <div class="col text-right">
                            <button @click="deleteCompetitor(competitor.id)" class="btn btn-danger" v-if="coach_id"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <modal-result
            :competitor_id="competitor_id"
            :competition_id="competition_id"
            @result = "setResult"></modal-result>

<!--            modal-edit-competitor-->
            <div class="modal fade" :id="`modal-competitor-edit${competitor_id}`" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="date_of_birth" class="col-sm-4 col-form-label">Дата рождения<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="date_of_birth" v-model="date_of_birth" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weight" class="col-sm-2 col-form-label">Вес<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" step="0.01" class="form-control" id="weight" v-model="weight">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tehkval_id" class="col-sm-2 col-form-label">Пояс<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select type="text" class="form-control" v-model="tehkval_id" id="tehkval_id">
                                        <option v-for="tehkval in tehkvals"
                                                :value="tehkval.id"
                                                :key="tehkval.id"
                                                :selected="tehkval_id === tehkval.id">
                                            {{tehkval.belt_color}} ({{tehkval.title}})</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sportkval_id" class="col-sm-2 col-form-label">Разряд<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select type="text" class="form-control" v-model="sportkval_id" id="sportkval_id">
                                        <option v-for="sportkval in sportkvals"
                                                :value="sportkval.id"
                                                :key="sportkval.id"
                                                :selected="sportkval_id === sportkval.id">
                                            {{sportkval.short_title}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button data-dismiss="modal" @click="updateDataCompetitor" class="btn btn-primary">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>

</template>

<script>
import { eventEmitter } from './../../app'
import ModalResult from './ModalResult'
import ModalEditCompetitor from "./ModalEditCompetitor";

export default {
    name: "competitors-list",
    data() {
        return {
            loading: false,
            errors: [],
            search: '',
            competitors: [],
            agecategory_id: null,
            weightcategory_id: null,
            tehkvalgroup_id: null,
            tehkvals: [],
            sportkvals: [],
            coach_id: null,
            competitor_id: null,
            competitor: [],
            male: 1,
            female: 2,
            gender: null,
            date_of_birth: null,
            weight: null,
            tehkval_id: null,
            sportkval_id: null
        }
    },
    props: [
        'competition_id',
        'is_owner',
        'user'
    ],
    filters: {
        formatDate: date => new Date(date).toLocaleDateString(),
        formatName: name => name.slice(0,1) + '.',
    },
    components: {
        ModalResult,
        ModalEditCompetitor
    },
    created() {
        this.getCompetitors()

        axios.get(`/tehkval`)
            .then((response) => {
                this.tehkvals = response.data
            })

        axios.get(`/get-sportkvals`)
            .then((response) => {
                this.sportkvals = response.data
            })

        this.checkForm()
    },
    computed: {
      filteredList () {
              return this.competitors.filter(elem => {
                  return elem.athlete.user.secondname.toLowerCase().includes(this.search.toLowerCase())
              })
      }
    },
    methods: {

        checkForm: function (e) {
            if (this.competitor && this.competitors) {
                return true;
            }

            if (this.competitors.length < 0) {
                console.log(this.competitors.length)

            }
            if (!this.competitor) {
                this.errors.push('Не выбран участник');
            }

            e.preventDefault();
        },

        getCompetitors() {
            this.loading = true
            axios.get(`/api/competitors-api`, {
                params: {
                    competition_id: this.competition_id,
                    coach_id: this.coach_id,
                    agecategory_id: this.agecategory_id,
                    weightcategory_id: this.weightcategory_id,
                    tehkvalgroup_id: this.tehkvalgroup_id
                }
            })
                .then((response) => {
                    if (response.data.length === 0) {
                        return this.loading = false
                    }

                    this.competitors = response.data
                    this.loading = false
                    this.getCompetitorsCount()
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },

        getCompetitor (id) {
            this.competitor_id = id
            this.competitor = this.competitors.filter(competitor => {
                return competitor.id === id
            })

            this.gender = this.competitor[0].athlete.gender
            this.date_of_birth = this.competitor[0].athlete.user.date_of_birth
            this.weight = this.competitor[0].weight
            this.tehkval_id = this.competitor[0].athlete.tehkval.reduce((acc, curr) => acc.id > curr.id ? acc : curr).id
            this.sportkval_id = this.competitor[0].athlete.sportkval.reduce((acc, curr) => acc.id > curr.id ? acc : curr).id
        },

        updateDataCompetitor () {
            axios.post(`/api/competitors-update-data/${this.competitor_id}`, {
                params: {
                    competition_id: this.competition_id,
                    gender: this.gender,
                    date_of_birth: this.date_of_birth,
                    weight: this.weight,
                    tehkval_id: this.tehkval_id,
                    sportkval_id: this.sportkval_id
                }
            })
                .then((response) => {
                    this.competitors = this.competitors.map(competitor => {
                            competitor.date_of_birth = response.data.athlete.user.date_of_birth,
                            competitor.weight = response.data.weight,
                            competitor.weightcategory = response.data.weightcategory,
                            competitor.tehkval_id = response.data.athlete.tehkval_id,
                            competitor.sportkval_id = response.data.athlete.sportkval_id
                            competitor.tehkvalgroup = response.data.tehkvalgroup
                            competitor.agecategory = response.data.agecategory
                        return competitor
                    })
                })
        },

        getCompetitorId(id) {
          this.competitor_id = id
        },

        getCompetitorsCount(){
            eventEmitter.$emit('getCompetitorsCount', this.competitors)
        },

        editDataCompetitor(data) {

        },

        setResult (data) {
            if (data.print_certificate) {
                window.open(
                    `/../printCompetitorsСertificate?competitor_id=${data.competitor_id}&competition_id=${data.competition_id}`,
                    '_download')
            }

            this.competitors = this.competitors.map(competitor => {
                competitor.count_winner = data.count_winner
                competitor.place = data.place

                return competitor
            })
        },

        deleteCompetitor (id) {
            axios.delete(`/api/competitors-api/${id}`)
                .then((response) => {
                    this.competitors = this.competitors.filter(competitor => {
                        return competitor.id !== id
                    })
                })
        }

    },
    mounted() {
        this.getCompetitorsCount()
        eventEmitter.$on('getCoachId', coach_id => {
            this.coach_id = coach_id
            this.getCompetitors();
        })
        eventEmitter.$on('getSearchString', search => {
            this.search = search
        })
        eventEmitter.$on('getAgeCategoryId', age_category_id => {
            this.agecategory_id = age_category_id
            if (this.agecategory_id === '') {
                    this.weightcategory_id = null
                this.tehkvalgroup_id = null
            }
            this.getCompetitors();

        })
        eventEmitter.$on('getWeightCategoryId', weightcategory_id => {
            this.weightcategory_id = weightcategory_id
            this.getCompetitors();
        })
        eventEmitter.$on('getTehKvalGroupId', tehkvalgroup_id => {
            this.tehkvalgroup_id = tehkvalgroup_id
            this.getCompetitors();
        })
    }
}
</script>

<style scoped>
.competitors-list {
    padding: 0 0.5rem
}
</style>
