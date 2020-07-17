<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th v-for="(head, index) in objData.headers" :key="index">{{ head }}</th>
                    <th>Actions</th>
                </tr>
                    
            </thead>
            <tbody>
                <!-- recorre un array segun el # de filas obtenidas -->
                <tr v-for="(row, index) in objData.rows" :key="index">
                    <!-- recorre objeto segun el # de columnas que contenga -->
                    <td v-for="(value, k,i) in objData.rows[index]" :key="i">
                        <!-- valida cuando esta recorriendo el ultimo campo para crear el td actions -->
                        <template  v-if="i > objData.headers.length-1">
                            <button type="button" @click="updateItem(objData.rows[index])" class="btn btn-primary btn-sm">Editar</button> 

                            <button type="button" @click="deleteItem(objData.rows[index].id)" class="btn btn-danger btn-sm">Borrar</button> 
                        </template>
                        <template v-else>
                        {{value}}
                        </template>
                    </td>
                   
                </tr>
                
            </tbody>
        </table>
        <button type="button" @click="openModal" class="btn btn-primary text-capitalize">
        Nuevo {{objData.item}}
        </button>
        <div id="exampleModal" ref="modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  text-capitalize">{{ modalAction }} {{ objData.item }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                 <!-- crea los campos basado en el objsave y asigna v-model a cada propiedad del mismo y placeholder el valor de los headers -->
                    <div v-for="(f, k, i) in objSave" :key="i" class="form-group">

                        <input class="form-control" type="text" :placeholder="headers[i]"  v-model="objSave[k]">
                        <!-- <input v-for="(f, k, i) in objSave" :key="i"   class="form-control" type="text" :placeholder="headers[i]"  v-model="objSave[k]"> este funciona-->
                    </div>
                       
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" @click="createItem()" class="btn btn-primary">{{ modalAction }}</button>
            </div>
            </div>
        </div>
</div> 
    </div>
</template>

<script>
    export default {
        name: 'DataTable',
        data: () => ({
            objDefault:{},
            headers:[],
            modalAction: '',
            objSave: {},
            objData:{},
        }),
        beforeCreate(){
            console.log('before create');
        },
        created(){
            console.log('create');

        },
        mounted(){
            this.readItem()
            console.log('mounted');
        },
        methods: {
            createItem(){
                axios.post('/services', 
                    // this.objData.rows[0]
            )
                .then((res) => {
                    $('#exampleModal').modal('hide'); 
                    console.log('POSt ok');
                    console.log(res.data);
                        // this.readItem();
                })
                .catch(function(err) {
                    console.log(err);
                })
                // .then(() => {
                    //     // this.readItem()
                //     console.log('then 2');
                // // loading.style.display = 'none';
                // })
                .finally( () => this.readItem());


            },
            readItem(){
                axios.get('/getallrows')
                .then( (res) => {
                    this.objData = res.data
                    this.objDefault = res.data.fields
                    this.headers = res.data.headers
                    // this.objDefault = Object.assign({}, res.data.fields)
                    console.log(res.data)
                })
                .catch( (err) => console.error(err))
                .finally( () => console.log('finish'))
            },
            updateItem(row){
                // alert('edit: '+ id) atraces de row injectar datos en fields
                // console.log(row);
                this.modalAction = 'Editar'
                this.objSave = Object.assign({}, row)
                delete this.objSave.id;
                $('#exampleModal').modal('show'); 
            },
            deleteItem(id){
                alert('delete: '+ id)
            },
            openModal(){
                this.modalAction = 'Nuevo'
                this.objSave = Object.assign({}, this.objDefault)
                // this.objSave = {}
                $('#exampleModal').modal('show'); 
            }
        }
    }
</script>

<style scoped>

</style>