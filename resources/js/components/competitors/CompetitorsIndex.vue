<template>
    <div>
        <div class="content-header">
            <div class="card collapsed-card">
                <div class="card-header">
                    <h1 class="card-title">{{ competition.title }}</h1>
                    <div class="card-tools">
                        <button
                            type="button"
                            class="btn btn-tool"
                            data-card-widget="collapse"
                            title="Collapse"
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <coach-select
                        :competition_id="competition.id"
                        :is_owner="is_owner"
                        :user="user"
                    ></coach-select>
                    <age-categories-select
                        :competition_id="competition.id"
                    ></age-categories-select>
                    <weight-categories-select></weight-categories-select>
                    <teh-kval-group-select
                        :competition_id="competition.id"
                    ></teh-kval-group-select>
                </div>
            </div>
        </div>

        <competitors-list
            :competition_id="competition.id"
            :competition_open_registration="competition.open_registration"
            :key="competition.id"
            :is_owner="is_owner"
            :user="user"
        ></competitors-list>
    </div>
</template>

<script>
import CompetitorsList from "./CompetitorsList";
import CoachSelect from "./filters/CoachSelect";
import AgeCategoriesSelect from "./filters/AgeCategoriesSelect";
import WeightCategoriesSelect from "./filters/WeightCategoriesSelect";
import TehKvalGroupSelect from "./filters/TehKvalGroupSelect";

export default {
    name: "competitors-index",
    data() {
        return {};
    },
    props: {
        competition: Object,
        coach_constant: Array,
        is_owner: Number,
        user: Object,
    },
    components: {
        TehKvalGroupSelect,
        CompetitorsList,
        CoachSelect,
        AgeCategoriesSelect,
        WeightCategoriesSelect,
    },
    created() {},
    methods: {},
    mounted() {},
};
</script>

<style scoped></style>
