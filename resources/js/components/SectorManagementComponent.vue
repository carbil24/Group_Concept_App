<template>
  <v-data-table
    :headers="headers"
    :items="sectors"
    :search="search"
    sort-by="title"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Sector Management</v-toolbar-title>
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
            >New Sector</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle  }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form :inline="true" :model="sector" class="demo-form-inline" lazy-validation ref="ruleSectorForm">
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="sector.title"
                                          label="Sector name"
                                          :rules="rules.sectorRules.title"
                                          required
                                      ></v-text-field>
                                  </v-col>
                                </v-row>
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="sector.description"
                                          label="Sector description"
                                          :rules="rules.sectorRules.description"
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
        @click="deleteSector(item)"
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
      sector: {title: '', description: '', },
      headers: [
        { text: 'Sector Name', align: 'start', value: 'title', },
        { text: 'Description', value: 'description' },

        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      sectors: [],
      editedIndex: -1,
      rules:  {
        sectorRules:{
            title: [v => !!v || "Please input the sector name"],
            description: [v => !!v || "Please input the description"],
        },
      },
    }
  },
    created(){
    axios.get('http://178.128.238.235/api/v1/sectors').then(res=>{
      this.sectors = res.data;
    })
  },
  computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Sector' : 'Edit Sector'
      },
  },

  watch: {
      dialog (val) {
        val || this.close()
      },
  },

  methods:{
        add(){
          const newSector = this.sector;
          this.sector = {title: '', description: '',};

          axios.post('http://178.128.238.235/api/v1/sectors', newSector)
          .then((res) =>{
            const sectorServer = res.data;
            this.sectors.push(sectorServer);
          })

          Swal.fire({
            icon: 'success',
            title: 'Sector created successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        editItem(item){
          this.editedIndex = this.sectors.indexOf(item)
          this.sector.title = item.title;
          this.sector.description = item.description;
          this.sector.id = item.id;

          this.dialog = true
        },
        updateSector(sector){ 
          const params = {title: sector.title, description: sector.description,};

          axios.put(`http://178.128.238.235/api/v1/sectors/${sector.id}`, params)
          .then(res=>{
            this.editMode = false;
            const index = this.sectors.findIndex(item => item.id === sector.id);
            this.sectors[index] = res.data;

            axios.get('http://178.128.238.235/api/v1/sectors').then(res=>{
                this.sectors = res.data;
            })

            this.sector = {title: '', description: '',};    

          })

          Swal.fire({
            icon: 'success',
            title: 'Sector updated successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        deleteSector(sector){
          const index = this.sectors.indexOf(sector)
          Swal.fire({
              title: `Delete sector ${sector.title + ' '}?`,
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
                title: 'Sector deleted successfully',
                showConfirmButton: false,
                timer: 2200
                })

                axios.delete(`http://178.128.238.235/api/v1/sectors/${sector.id}`)
                .then(()=>{
                    this.sectors.splice(index, 1);
                })
              }
          })
        },
        close () {
          this.dialog = false
          this.$refs.ruleSectorForm.reset()

          this.$nextTick(() => {
            this.sector = {title: '', description: '',};
            this.editedIndex = -1
          })
        },
        save() {
          if (this.sector.title === '' || this.sector.description === ''){
              return new Promise((resolve, reject) => {
                  this.$refs.ruleSectorForm.validate((valid) => {
                      resolve(valid);
                  });
              })
          }
          else{
            if (this.editedIndex > -1) {
                this.updateSector(this.sector);
            } else {
                this.add();
            }
            this.close()
            }
        },
    },
}
</script>