<template>
    <div>
        <div class="content-header">
            <div class="card collapsed-card">
                <div class="card-header">
                    <h1 class="card-title">Соревнования</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <coach-select
                        :competition_id="competition_id"
                        @coach_id="onChange"></coach-select>
                    <age-categories-select
                        :competition_id="competition_id"></age-categories-select>

                </div>
            </div>
        </div>

        <competitors-list :competition_id="competition_id"
                          :coach_id="coach_id"
                          :key="competition_id"></competitors-list>

    </div>

</template>

<script>
import CompetitorsList from './CompetitorsList'
import CoachSelect from './filters/CoachSelect'
import AgeCategoriesSelect from "./filters/AgeCategoriesSelect";

export default {
    name: "competitors-index",
    data() {
        return {
            coach_id: null
        }
    },
    props: [
      'competition_id',
        'coach_constant'
    ],
    components: {
        CompetitorsList,
        CoachSelect,
        AgeCategoriesSelect
    },
    created() {
        console.log(this.coach_constant)
    },
    methods: {
        onChange(data) {
            this.coach_id = data.coach_id
        }
    },
    mounted() {

    }

}

</script>

<style scoped>

</style>
