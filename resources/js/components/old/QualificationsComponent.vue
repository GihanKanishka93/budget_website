<template>
    <div>
        <div v-for="(item, index) in qualifications" :key="index" class="card mb-2">
            <div class="card-body">
                <div class="form-floating mb-3">
                    <input v-model="item.type" type="text" class="form-control" placeholder="" />
                    <label>Type</label>
                </div>
                <div class="form-floating mb-3">
                    <input v-model="item.name" type="text" class="form-control" placeholder="" />
                    <label for="floatingPassword">Name</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            count: 3,
            qualificationObj: {
                type: '',
                name: ''
            }
        }),  
        props: ['qualifications'],
        created() {
            for (let index = 0; index < this.count; index++) {
                this.qualifications.push({...this.qualificationObj})
            }
        },
        methods: {     
        }
    }
</script>
