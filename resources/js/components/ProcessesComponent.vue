<template>
    <div class="col-6">
        <h5 class="card-title text-start mb-2">Process(Optional)</h5>
        <div v-for="(item, index) in processes" :key="index" class="card mb-3">
            <div class="card-body">
                <div class="form-floating mb-3">
                    <input v-model="item.title" type="text" class="form-control form-control-sm"
                        placeholder="Certificate/Awards/Qualifications"
                        required />
                    <label>Title</label>
                </div>
                <div class="form-floating">
                    <textarea v-model="item.description" class="form-control" placeholder="Leave a comment here" :id="`serviceTextarea`+index"
                        style="height: 100px"></textarea>
                    <label :for="`serviceTextarea`+index">Description</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: () => ({
            count: 5,
            processObj: {
                title: '',
                description: ''
            },
        }),  
        props: ['processes'],
        created() {
            for (let index = 0; index < this.count; index++) {
                this.processes.push({...this.processObj})
            }
        },
        methods: {     
        }
    }
</script>
