<template>
  <v-data-table
    :headers="headers"
    :items="categories"
    :search="search"
    sort-by="title"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Category Management</v-toolbar-title>
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
            >New Category</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle  }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form :inline="true" :model="category" class="demo-form-inline" lazy-validation ref="ruleCategoryForm">
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="category.title"
                                          label="Category name"
                                          :rules="rules.categoryRules.title"
                                          required
                                      ></v-text-field>
                                  </v-col>
                                </v-row>
                                <v-row>
                                  <v-col cols="12" md="12">
                                      <v-text-field
                                          v-model="category.description"
                                          label="Category description"
                                          :rules="rules.categoryRules.description"
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
        @click="deleteCategory(item)"
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
      category: {title: '', description: '', },
      headers: [
        { text: 'Category Name', align: 'start', value: 'title', },
        { text: 'Description', value: 'description' },

        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      categories: [],
      editedIndex: -1,
      rules:  {
        categoryRules:{
            title: [v => !!v || "Please input the category name"],
            description: [v => !!v || "Please input the description"],
        },
      },
    }
  },
    created(){
    axios.get('http://178.128.238.235/api/v1/categories').then(res=>{
      this.categories = res.data;
    })
  },
  computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Category' : 'Edit Category'
      },
  },

  watch: {
      dialog (val) {
        val || this.close()
      },
  },

  methods:{
        add(){
          const newCategory = this.category;
          this.category = {title: '', description: '',};

          axios.post('http://178.128.238.235/api/v1/categories', newCategory)
          .then((res) =>{
            const categoryServer = res.data;
            this.categories.push(categoryServer);
          })

          Swal.fire({
            icon: 'success',
            title: 'Category created successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        editItem(item){
          this.editedIndex = this.categories.indexOf(item)
          this.category.title = item.title;
          this.category.description = item.description;
          this.category.id = item.id;

          this.dialog = true
        },
        updateCategory(category){ 
          const params = {title: category.title, description: category.description,};

          axios.put(`http://178.128.238.235/api/v1/categories/${category.id}`, params)
          .then(res=>{
            this.editMode = false;
            const index = this.categories.findIndex(item => item.id === category.id);
            this.categories[index] = res.data;

            axios.get('http://178.128.238.235/api/v1/categories').then(res=>{
                this.categories = res.data;
            })

            this.category = {title: '', description: '',};    

          })

          Swal.fire({
            icon: 'success',
            title: 'Category updated successfully',
            showConfirmButton: false,
            timer: 2200
          })
        },
        deleteCategory(category){
          const index = this.categories.indexOf(category)
          Swal.fire({
              title: `Delete category ${category.title + ' '}?`,
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
                title: 'Category deleted successfully',
                showConfirmButton: false,
                timer: 2200
                })

                axios.delete(`http://178.128.238.235/api/v1/categories/${category.id}`)
                .then(()=>{
                    this.categories.splice(index, 1);
                })
              }
          })
        },
        close () {
          this.dialog = false
          this.$refs.ruleCategoryForm.reset()

          this.$nextTick(() => {
            this.category = {title: '', description: '',};
            this.editedIndex = -1
          })
        },
        save() {
          if (this.category.title === '' || this.category.description === ''){
              return new Promise((resolve, reject) => {
                  this.$refs.ruleCategoryForm.validate((valid) => {
                      resolve(valid);
                  });
              })
          }
          else{
            if (this.editedIndex > -1) {
                this.updateCategory(this.category);
            } else {
                this.add();
            }
            this.close()
            }
        },
    },
}
</script>