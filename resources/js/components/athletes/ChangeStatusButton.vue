<template>
    <div class="row">
        <div class="col-auto mr-auto">
            <span
                v-if="athlete.status === 1"
                v-on:click="changeStatus"
                class="badge badge-danger" style="cursor: pointer">деактивировать</span>
            <span
                v-else
                v-on:click="changeStatus"
                class="badge badge-success" style="cursor: pointer">активировать</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "change-status-button",
        data() {
            return {
                status: 0,
                athlete: []
            }
        },
        props: [
          'athlete_id'
        ],

        methods: {
            getAthlete() {
                axios.get(`/api/athletes-api/`+this.athlete_id)
                    .then((response) => {
                        this.athlete = response.data
                    })
            },
            changeStatus () {
                if (this.athlete.status === 1) {
                    this.status = 2
                } else {
                    this.status = 1
                }
                const params = {
                    id: this.athlete.id,
                    status: this.status
                }
                axios.put(`/api/athletes-api/{id}`, params)
                    .then((response) => {
                        this.athlete = response.data
                        this.getAthlete()
                    })

            }
        },
        mounted() {
           this.getAthlete();
        }
    }
</script>
