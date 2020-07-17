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
                 <!-- crea los campos basado en el objCurrent y asigna v-model a cada propiedad del mismo y placeholder el valor de los headers -->
                    <div v-for="(f, k, i) in objCurrent" :key="i" class="form-group">

                        <input class="form-control" type="text" :placeholder="objData.headers[i]"  v-model="objCurrent[k]">
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
            objDefault:{}, // para reiniciar el objCurrent sin perder el modelo
            objSend:{}, // para tomar un item de la tabla con el id
            modalAction: '', // captura la accion de guardado o actualizado
            objCurrent: {}, // enlaza los campos de entrada para ser enviados
            objData:{}, // contiene la data necesesaria del back-end para el componente front-end
        }),
        beforeCreate(){
        },
        created(){

        },
        mounted(){
            // llama el metodo cuando se monta el componente
            this.readItem()
        },
        methods: {
            // determina la accion a realizar cuando se pulsa el boton Crear/Editar del modal
            createItem(){
                if (this.modalAction == 'Nuevo') {
                    axios.post('/services', 
                    this.objCurrent
            )
                .then((res) => {
                    $('#exampleModal').modal('hide'); 
                        this.readItem();
                })
                .catch(function(err) {
                })
                .finally( () => this.readItem());
                } else {
                    this.objCurrent.id = this.objSend.id
                    axios.patch('/services', 
                        this.objCurrent
                        
                )
                    .then((res) => {
                        $('#exampleModal').modal('hide'); 
                            this.readItem();
                    })
                    .catch(function(err) {
                        console.log(err);
                    })
                    .finally( () => this.readItem());
                }


            },
            // obtiene desde el back-end las filas de una tabla en la DB y los datos para el funcionamiento del componente
            readItem(){
                axios.get('/getallrows')
                .then( (res) => {
                    this.objData = res.data
                    this.objDefault = res.data.fields
                })
                .catch( (err) => console.error(err))
            },
            // toma un objeto item al pulsar el boton editar y lo enlaza con los campos de entrada excluyendo la propiedad id
            updateItem(row){
                this.modalAction = 'Editar'
                this.objCurrent = Object.assign({}, row)
                this.objSend = Object.assign({}, row)
                delete this.objCurrent.id;
                $('#exampleModal').modal('show'); 
            },
            deleteItem(id){
                alert('delete: '+ id)
            },
            // activa la visibilidad del modal
            openModal(){
                this.modalAction = 'Nuevo'
                this.objCurrent = Object.assign({}, this.objDefault)
                $('#exampleModal').modal('show'); 
            }
        }
    }
</script>

<style scoped>

</style>