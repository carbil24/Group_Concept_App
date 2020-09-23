<template>
  <v-data-table
    :headers="headers"
    :items="products"
    :search="search"
    sort-by="prod_code"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>Product Management</v-toolbar-title>
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
            >New Product</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle  }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-form :inline="true" :model="product" class="demo-form-inline" lazy-validation ref="ruleProductForm">
                                <v-row>
                                    <v-col cols="12" md="6" lg="6">
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <v-text-field
                                                    v-model="product.prod_code"
                                                    label="Product code"
                                                    :rules="rules.productRules.prod_code"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                                <v-text-field
                                                    v-model="product.title"
                                                    label="Product name"
                                                    :rules="rules.productRules.title"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                          <v-col cols="12" md="12">
                                              <v-text-field
                                                  v-model="product.um"
                                                  label="UM"
                                                  :rules="rules.productRules.um"
                                                  required
                                              ></v-text-field>
                                          </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="6">
                                        <v-col cols="12" xs="8" class="text-xs-center text-sm-center text-md-center text-lg-center">
                                          <v-text-field 
                                            label="Image" 
                                            @click='pickFile' 
                                            v-model='product.image_path'
                                            :rules="rules.productRules.image_path"
                                            prepend-icon='mdi-camera'>
                                          </v-text-field>
                                          <input
                                              type="file"
                                              style="display: none"
                                              ref="imageInput"
                                              accept="image/*"
                                              @change="onFilePicked"
                                          >
                                        <v-img :src="imageUrl" height="180" width="140" v-if="imageUrl" @click='pickFile'/>
                                        <v-img src="/images/default.png" height="160" width="160" v-if="!imageUrl" @click='pickFile'/>

                                        </v-col>
                                    </v-col>
                                </v-row>
                                
                                <v-row>
                                    <v-col cols="12" md="6">
                                      <v-select
                                          v-model="product.supplier_id"
                                          :items="suppliers"
                                          item-text="title"
                                          item-value="id"
                                          label="Supplier"
                                          :rules="rules.productRules.supplier_id"
                                          required
                                      ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-select
                                            v-model="product.sector_id"
                                            :items="sectors"
                                            item-text="title"
                                            item-value="id"
                                            label="Sector"
                                            :rules="rules.productRules.sector_id"
                                            required
                                        ></v-select>
                                    </v-col>

                                </v-row>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-select
                                            v-model="product.category_id"
                                            :items="categories"
                                            item-text="title"
                                            item-value="id"
                                            label="Category"
                                            :rules="rules.productRules.category_id"
                                            required
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="product.unity_price"
                                            label="Unit price"
                                            :rules="rules.productRules.unity_price"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col cols="12" md="6"> 
                                        <v-text-field
                                            v-model="product.sug_retail_price"
                                            label="Retail price"
                                            :rules="rules.productRules.sug_retail_price"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="product.item_code"
                                            label="Item code"
                                            :rules="rules.productRules.item_code"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="product.short_desc"
                                            label="Description"
                                            :rules="rules.productRules.short_desc"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="product.brand"
                                            label="Brand"
                                            :rules="rules.productRules.brand"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                
                                <v-row>
                                    <v-col cols="12" md="12">
                                      <v-textarea
                                        v-model="product.detailed_desc"
                                        :rules="rules.productRules.detailed_desc"
                                        required
                                      >
                                        <template v-slot:label>
                                          <div>
                                            Detailed description
                                          </div>
                                        </template>
                                      </v-textarea>
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
    <template v-slot:[`item.supplier_id`]="{ item }">
      <td v-for="(supplier, index) in suppliersFiltered(item.supplier_id)" :key="'supplier'+ index">{{supplier.title}}</td>
    </template>
    <template v-slot:[`item.sector_id`]="{ item }">
      <td v-for="(sector, index) in sectorsFiltered(item.sector_id)" :key="'sector'+ index">{{sector.title}}</td>
    </template>
    <template v-slot:[`item.category_id`]="{ item }">
      <td v-for="(category, index) in categoriesFiltered(item.category_id)" :key="'category'+ index">{{category.title}}</td>
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
        @click="deleteProduct(item)"
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
      product: {prod_code: '', title: '', um: '', supplier_id: '', sector_id:'', category_id: '', 
                brand: '', unity_price: '', sug_retail_price: '', item_code: '', short_desc: '', image_path: '', detailed_desc: ''},
      headers: [
        { text: 'Product Code', align: 'start', sortable: false, value: 'prod_code', },
        { text: 'Product Name', value: 'title' },
        { text: 'Supplier', value: 'supplier_id' },
        { text: 'Sector', value: 'sector_id' },
        { text: 'Category', value: 'category_id' },
        { text: 'Brand', value: 'brand' },
        { text: 'Unit Price', value: 'unity_price' },

        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      products: [],
      categories: [],
      suppliers: [],
      sectors: [],
      editedIndex: -1,
      rules:  {
        productRules:{
            prod_code:[v => !!v || "Please input the product code"],
            title: [v => !!v || "Please input the product name"],
            um: [v => !!v || "Please input the UM"],
            supplier_id: [v => !!v || "Please select the supplier"],
            sector_id: [v => !!v || "Please select the sector"],
            category_id: [v => !!v || "Please select the category"],
            brand:[v => !!v || "Please input the brand"],
            unity_price: [v => !!v || "Please input the unity price"],
            sug_retail_price: [v => !!v || "Please input the retail price"],
            item_code:[v => !!v || "Please input the item code"],
            short_desc: [v => !!v || "Please input the description"],
            image_path: [v => !!v || "Please select the image"],
            detailed_desc:[v => !!v || "Please input the detailed description"],
        },
      },
      imageName: '',
      imageUrl: '',
      imageFile: ''
    }
  },
    created(){
    axios.get('http://178.128.238.235/api/v1/products').then(res=>{
      this.products = res.data;
      //console.log(this.products);
    })
    axios.get('http://178.128.238.235/api/v1/categories').then(res=>{
      this.categories = res.data;
    })
    axios.get('http://178.128.238.235/api/v1/suppliers').then(res=>{
      this.suppliers = res.data;
    })
    axios.get('http://178.128.238.235/api/v1/sectors').then(res=>{
      this.sectors = res.data;
    })

  },
  computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Product' : 'Edit Product'
      },
  },

  watch: {
      dialog (val) {
        val || this.close()
      },
  },

  methods:{
        add(){
          const newProduct = this.product;          
          this.product = {prod_code: '', title: '', um: '', supplier_id: '', sector_id:'', category_id: '', 
                          brand: '', unity_price: '', sug_retail_price: '', item_code: '', short_desc: '', image_path: '', detailed_desc: ''};

          this.uploadImage();

          axios.post('http://178.128.238.235/api/v1/products', newProduct)
          .then((res) =>{           
            const productServer = res.data;
            this.products.push(productServer);
            
            axios.get('http://178.128.238.235/api/v1/products').then(res=>{
                this.products = res.data;
            })  
          })
   

          Swal.fire({
            icon: 'success',
            title: 'Product created successfully',
            showConfirmButton: false,
            timer: 2200
            }).then(() => {
              window.top.location = window.top.location
          })
        },
        editItem(item){
          this.editedIndex = this.products.indexOf(item)
          this.product.prod_code = item.prod_code;
          this.product.title = item.title;
          this.product.um = item.um;
          this.product.supplier_id = item.supplier_id;
          this.product.sector_id = item.sector_id;
          this.product.category_id = item.category_id;
          this.product.brand = item.brand;
          this.product.unity_price = item.unity_price;
          this.product.sug_retail_price = item.sug_retail_price;
          this.product.item_code = item.item_code;
          this.product.short_desc = item.short_desc;
          this.product.image_path = item.image_path;
          this.product.detailed_desc = item.detailed_desc;
          this.product.id = item.id;

          this.imageUrl = ('/upload/' + item.image_path);

          this.dialog = true
        },
        updateProduct(product){ 
          
          const params = {prod_code: product.prod_code, title: product.title, um: product.um, supplier_id: product.supplier_id,
                          sector_id: product.sector_id, category_id: product.category_id, brand: product.brand, unity_price: product.unity_price,
                          sug_retail_price: product.sug_retail_price, item_code: product.item_code, short_desc: product.short_desc,
                          image_path: product.image_path, detailed_desc: product.detailed_desc,};          

          this.product = {prod_code: '', title: '', um: '', supplier_id: '', sector_id:'', category_id: '', 
                            brand: '', unity_price: '', sug_retail_price: '', item_code: '', short_desc: '', image_path: '', detailed_desc: ''}; 

          axios.put(`http://178.128.238.235/api/v1/products/${product.id}`, params)
          .then(res=>{
            const index = this.products.findIndex(item => item.id === product.id);
            this.products[index] = res.data;
            

            axios.get('http://178.128.238.235/api/v1/products').then(res=>{
                this.products = res.data;
            })   

          })
          

            if(this.imageName){
              this.uploadImage();
            }

          Swal.fire({
            icon: 'success',
            title: 'Product updated successfully',
            showConfirmButton: false,
            timer: 2200
            }).then(() => {
              window.top.location = window.top.location
          })
        },
        deleteProduct(product){
          const index = this.products.indexOf(product)
          Swal.fire({
              title: `Delete product ${product.title + ' '}?`,
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
                title: 'Product deleted successfully',
                showConfirmButton: false,
                timer: 2200
                })

                axios.delete(`http://178.128.238.235/api/v1/products/${product.id}`)
                .then(()=>{
                    this.products.splice(index, 1);
                })
              }
          })
        },
        close() {
          this.dialog = false
          this.$refs.ruleProductForm.reset()
          this.$nextTick(() => {
            this.product = {prod_code: '', title: '', um: '', supplier_id: '', sector_id:'', category_id: '', 
                            brand: '', unity_price: '', sug_retail_price: '', item_code: '', short_desc: '', image_path: '', detailed_desc: ''};
            this.editedIndex = -1
            
            this.imageName = ''
            this.imageFile = ''
            this.imageUrl = ''
          })
        },
        save() {
          if (!this.product.prod_code || !this.product.title || !this.product.um ||
              !this.product.supplier_id || !this.product.sector_id || !this.product.category_id || 
              !this.product.brand || !this.product.unity_price || !this.product.sug_retail_price || 
              !this.product.item_code || !this.product.short_desc || !this.product.image_path || 
              !this.product.detailed_desc) {
              return new Promise((resolve, reject) => {
                  this.$refs.ruleProductForm.validate((valid) => {
                      resolve(valid);
                  });
              })
          }
          else{
            if (this.editedIndex > -1) {
                this.updateProduct(this.product);
            } else {
                this.add();
            }
            this.close()
            }
        },
        suppliersFiltered: function (supplier_id) {
            return this.suppliers.filter(el => el.id === supplier_id)
        },
        categoriesFiltered: function (category_id) {
            return this.categories.filter(el => el.id === category_id)
        },
        sectorsFiltered: function (sector_id) {
            return this.sectors.filter(el => el.id === sector_id)
        },
        uploadImage() {
            let currentObj = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                }
            }
            // form data
            let formData = new FormData();
            formData.append('file', this.imageFile);

            // send upload request
            axios.post('/store_file', formData, config)
                .then(resp => {
                    currentObj.success = resp.data.success;
                    currentObj.filename = "";
                })
                .catch(function (error) {
                    currentObj.output = error;
                    console.log(currentObj.output)
                });
        },
        pickFile() {
          this.$refs.imageInput.click()
        },
        onFilePicked(e) {
            const files = e.target.files
            if (files[0] !== undefined) {
                this.imageName = files[0].name
                if (this.imageName.lastIndexOf('.') <= 0) {
                return
                }
                const fr = new FileReader()
                fr.readAsDataURL(files[0])
                fr.addEventListener('load', () => {
                this.imageUrl = fr.result
                this.imageFile = files[0] // this is an image file that can be sent to server...
                this.product.image_path = this.imageName;
                })
            } else {
                this.imageName = ''
                this.imageFile = ''
                this.imageUrl = ''
            }
        },
    },
}
</script>