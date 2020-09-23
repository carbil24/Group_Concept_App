<template>
  <v-data-table
    :headers="headers"
    :items="suppliers"
    :search="search"
    sort-by="title"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Supplier Management</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >New Supplier</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle  }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form :inline="true" :model="supplier" class="demo-form-inline" lazy-validation ref="ruleSupplierForm">
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="supplier.title"
                                          label="Supplier name"
                                          :rules="rules.supplierRules.title"
                                          required
                                      ></v-text-field>
                                  </v-col>
                                </v-row>
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="supplier.description"
                                          label="Supplier description"
                                          :rules="rules.supplierRules.description"
                                          required
                                      ></v-text-field>
                                  </v-col>
                                </v-row>
                        </v-form>

                  </v-container>  
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteSupplier(item)"
      >
        mdi-delete
      </v-icon>
    </template>
  </v-data-table>


</template>

<script>
export default {
  data() {
    return {
      search: '',
      dialog: false,
      supplier: {title: '', description: '', },
      headers: [
        { text: 'Supplier Name', align: 'start', value: 'title', },
        { text: 'Description', value: 'description' },

        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      suppliers: [],
      editedIndex: -1,
      rules:  {
        supplierRules:{
            title: [v => !!v || "Please input the supplier name"],
            description: [v => !!v || "Please input the description"],
        },
      },
    }
  },
    created(){
    axios.get('http://178.128.238.235/api/v1/suppliers').then(res=>{
      this.suppliers = res.data;
    })
  },
  computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Supplier' : 'Edit Supplier'
      },
  },

  watch: {
      dialog (val) {
        val || this.close()
      },
  },

  methods:{
        add(){
          const newSupplier = this.supplier;
          this.supplier = {title: '', description: '',};

          axios.post('http://178.128.238.235/api/v1/suppliers', newSupplier)
          .then((res) =>{
            const supplierServer = res.data;
            this.suppliers.push(supplierServer);
          })

          Swal.fire({
            icon: 'success',
            title: 'Supplier created successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        editItem(item){
          this.editedIndex = this.suppliers.indexOf(item)
          this.supplier.title = item.title;
          this.supplier.description = item.description;
          this.supplier.id = item.id;

          this.dialog = true
        },
        updateSupplier(supplier){ 
          const params = {title: supplier.title, description: supplier.description,};

          axios.put(`http://178.128.238.235/api/v1/suppliers/${supplier.id}`, params)
          .then(res=>{
            const index = this.suppliers.findIndex(item => item.id === supplier.id);
            this.suppliers[index] = res.data;

            axios.get('http://178.128.238.235/api/v1/suppliers').then(res=>{
                this.suppliers = res.data;
            })

            this.supplier = {title: '', description: '',};    

          })

          Swal.fire({
            icon: 'success',
            title: 'Supplier updated successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        deleteSupplier(supplier){
          const index = this.suppliers.indexOf(supplier)
          Swal.fire({
              title: `Delete supplier ${supplier.title + ' '}?`,
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.value) {
                Swal.fire({
                icon: 'success',
                title: 'Supplier deleted successfully',
                showConfirmButton: false,
                timer: 2200
                })

                axios.delete(`http://178.128.238.235/api/v1/suppliers/${supplier.id}`)
                .then(()=>{
                    this.suppliers.splice(index, 1);
                })
              }
          })
        },
        close () {
          this.dialog = false
          this.$refs.ruleSupplierForm.reset()

          this.$nextTick(() => {
            this.supplier = {title: '', description: '',};
            this.editedIndex = -1
          })
        },
        save() {
          if (this.supplier.title === '' || this.supplier.description === ''){
              return new Promise((resolve, reject) => {
                  this.$refs.ruleSupplierForm.validate((valid) => {
                      resolve(valid);
                  });
              })
          }
          else{
            if (this.editedIndex > -1) {
                this.updateSupplier(this.supplier);
            } else {
                this.add();
            }
            this.close()
            }
        },
    },
}
</script>