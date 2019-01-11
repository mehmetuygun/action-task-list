<template>
    <div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th>Id</th>
                    <th>Description</th>
                    <th>File</th>       
                    <th>Completed</th>
                    <th style="width: 1%">Action</th>
                </thead>
                <tbody>
                    <tr v-for="row in rows">
                        <td class="align-middle">{{ row.id }}</td>
                        <td class="align-middle">{{ row.description }}</td>
                        <td class="align-middle">
                            <div v-if="row.completed">
                                <a v-bind:href="'download/photo/' + row.id">Download</a>
                            </div>
                            <div v-else>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="taskFile" @change="selectFile">
                                </div>
                            </div>
                        </td>
                        <td class="align-middle"> 
                            <div v-if="row.completed">
                                <span class="badge badge-success">Done</span>
                            </div>
                            <div v-else>
                                <span class="badge badge-warning">Not Compeleted</span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div v-if="row.completed">
                                <a href="#" class="btn btn-danger"  v-on:click="uncompleteTask(row, $event)">Uncomplete</a>
                            </div>                 
                            <div v-else>
                                <a href="#" class="btn btn-success" v-on:click="completeTask(row, $event)">Complete</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                rows: '',
                file: '',
                form: new FormData,
                action_status: 0,
                errors: '',
                uploaded_file_location: ''
            }
        },
        methods: {
            getActionList() {
                axios.get('api/get/action')
                .then(response => {
                    this.rows = response.data.rows;
                    console.log(this.data.results);
                })
                .catch(e => {
                    // this.errors.push(e)
                });
            },
            uncompleteTask(row, event) {
                row.completed = 0;
                axios.post('api/uncomplete/action/'+row.id).then(response=>{

                })  
                .catch(response=>{
                    //error
                });
            },
            completeTask(row, event) {
                // change link to loading when it's first loaded
                event.target.classList.add('disabled');

                let self = this;

                let selected_file = event.target.parentElement.parentElement.parentElement.querySelector('#taskFile').value;

                if (selected_file) {

                    this.form.append('file',this.file);
                    this.form.append('action_id',row.id);
                    this.form.append('completed', 1);

                    axios.post('api/post/action', this.form).then(response=>{

                        self.action_status = response.data.status;

                        if (typeof response.data.errors !== 'undefined') {
                            self.errors = response.data.errors;
                        }

                        if (response.data.status) {
                            self.uploaded_file_location = response.data.file_location;
                            event.target.classList.remove('disabled');
                            row.completed = 1;
                            // self.rows[myArray.findIndex(x => x.id === row.id)].completed = 1;

                        }

                        if (self.action_status == 0) {
                            alert(self.errors.file[0]);
                            event.target.classList.remove('disabled');
                        }

                    })  
                    .catch(response=>{
                        //error
                    });

                } else {
                    alert('Choose a file to complete task');
                    event.target.classList.remove('disabled');                }
            }, 
            selectFile(e) {
                let selectedFiles=e.target.files;
                if(!selectedFiles.length){
                    return false;
                }
                this.file = selectedFiles[0];
                console.log(this.file);
            }
        },
        mounted() { 
            this.getActionList();
            console.log('Component mounted.')
        }
    }
</script>
