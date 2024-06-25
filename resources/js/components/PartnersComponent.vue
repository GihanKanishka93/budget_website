<template>
    <div class="col-6 text-start">
        <h5 class="card-title">
            Partner/ Lender Names and Logos(Optional)
        </h5>
        <div class="form-text mb-2">Having logos on a website creates trust, please add logos of any partners or customers that you would like to highlight in the website</div>
        <div id="logo-box">
            <div v-for="(item, index) in partners" :key="index" class="card mb-2">
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-2 col-form-label">Name</label>
                        <div class="col-6">
                            <input v-model="item.name" type="text" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-2 col-form-label">Logo</label>
                        <div class="col-6">
                            <input v-on:change="onLogoChange($event, index)" class="form-control form-control-sm" type="file" accept="image/png, image/jpeg"/>
                            <span v-if="item.upload === 1" class="material-symbols-outlined text-success float-end">check</span>
                            <span v-if="item.upload === 2" class="material-symbols-outlined text-danger float-end">close</span>
                        </div>
                    </div>
                    
                    <button v-if="partners.length>count" type="button" class="btn btn-danger btn-sm my-2 removeLogo" @click="removeLogo(index)">Remove</button>
                    <!-- <button type="button" class="btn btn-primary btn-sm my-2" @click="saveLogo(index)">Save</button> -->
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary btn-sm my-2" @click="addLogo" :ref="'addLogoBtn'">Add New</button>
    </div>
</template>

<script>
    export default {
        data: () => ({
            count: 5,
            logoData: new FormData(),
            logoObj: {
                name: '',
                logo: '',
                upload: 0
            }
        }),  
        props: ['partners'],
        mounted() {
            for (let index = 0; index < this.count; index++) {
                this.partners.push({...this.logoObj})
            }
        },
        methods: {        
            addLogo(){
                this.partners.push({...this.logoObj})
            },
            removeLogo(index){
                this.partners.splice(index, 1);
            },
            onLogoChange(e, index) {
                var files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.logoData.append("logo", files[0])
                this.saveLogo(index, files[0])
            },
            saveLogo(index) {
                axios.post("api/save-logo", this.logoData)
                .then(({data}) => {
                    this.partners[index]['logo'] = data
                    this.partners[index]['upload'] = 1
                })
                .catch((error) => {
                    error = error.data.message
                    this.partners[index]['upload'] = 2
                })
            }
        }
    }
</script>
