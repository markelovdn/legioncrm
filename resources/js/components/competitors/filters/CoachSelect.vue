<template>
    <div>
        <h6>Тренер</h6>
        <div class="col-9">
            <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id" v-model="coach_id" @change="getCoachId()">
                <option selected value="">Все ({{competitors.length}})</option>
                <option v-for="coach in coaches"
                    :value="coach.id"
                    :key="coach.id">
                    {{coach.user.secondname}} {{coach.user.firstname}} {{coach.user.patronymic}} ({{getCountAthletes(coach.id)}})
                </option>
                <option v-if="coach.id"
                        :value="coach.id"
                        :key="coach.id">
                    {{coach.user.secondname}} {{coach.user.firstname}} {{coach.user.patronymic}}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
import eventEmitter from 'tiny-emitter/instance'
export default {
    name: "coach-select",

    data() {
        return {
            coaches: [],
            coach_id: '',
            coach: [],
            competitors: []
        }
    },
    props: [
        'competition_id',
        'is_owner',
        'user'
    ],
    created() {
        this.getCoaches()
    },
    methods: {
        getCoaches() {
            axios.get(`/get-coaches-competition/` , {
                params: {
                    competition_id: this.competition_id
                }
            })
                .then((response) => {
                    if (this.is_owner){
                        this.coaches = response.data
                    } else {
                        this.coach = response.data.find(e => e.id === this.user.coach.id);
                    }
                 })
        },
        getCoachId(){
            eventEmitter.emit('getCoachId', this.coach_id)
        },
        getCountAthletes(coach_id) {
            const coaches = []
            let count = 0
            this.competitors.forEach(element => element.athlete.coaches.forEach(item => coaches.push(item)))

            for (const coach of coaches) {
                if (coach.id === coach_id & coach.pivot.coach_type === 4) count++;
            }
            return count
        }

    },
    mounted() {
        this.getCoaches()
        eventEmitter.on('getCompetitorsCount', competitors => {
            this.competitors = competitors
        })
    },
}
</script>

<style scoped>

</style>
