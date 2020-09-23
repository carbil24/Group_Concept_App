<template>
  <v-data-table
    :headers="headers"
    :items="users"
    :search="search"
    sort-by="title"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>User Management</v-toolbar-title>
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
      </v-toolbar>
    </template>
    <template v-slot:[`item.is_admin`]="{ item }">
        <v-simple-checkbox v-model="item.is_admin"></v-simple-checkbox>
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
        @click="deleteUser(item)"
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
      user: {name: '', email: '', is_admin: false,},
      headers: [
        { text: 'User Name', align: 'start', value: 'name', },
        { text: 'Email', value: 'email' },
        { text: 'Admin', value: 'is_admin' },

        { text: 'Actions', value: 'actions', sortable: false },
      ],
      
      users: [],
    }
  },
  
  created(){
    axios.get('/api/users').then(res=>{
      this.users = res.data;
      this.users.forEach(element => {
        if (element.is_admin === 1)
          element.is_admin = true;
        else
          element.is_admin = false
      });
    })
  },
  watch: {
      dialog (val) {
        val || this.close()
      },
  },

  methods:{
        editItem(item){
          this.editedIndex = this.users.indexOf(item)
          this.user = item;

          this.updateUser(this.user);
        },
        updateUser(user){
          const params = {is_admin: user.is_admin,};

          axios.put(`/api/users/${user.id}`, params)
          .then(res=>{
            const index = this.users.findIndex(item => item.id === user.id);
            this.users[index] = res.data;

            axios.get('/api/users').then(res=>{
                this.users = res.data;
                this.users.forEach(element => {
                  if (element.is_admin === 1)
                    element.is_admin = true;
                  else
                    element.is_admin = false
                });
            })

            this.user = {is_admin: false,};    

          })

          Swal.fire({
            icon: 'success',
            title: `User ${user.name} updated successfully`,
            showConfirmButton: false,
            timer: 2200
          })
        },
        deleteUser(user){
          const index = this.users.indexOf(user)
          Swal.fire({
              title: `Delete user ${user.name + ' '}?`,
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
                title: 'User deleted successfully',
                showConfirmButton: false,
                timer: 2200
                })

                axios.delete(`/api/users/${user.id}`)
                .then(()=>{
                    this.users.splice(index, 1);
                })
              }
          })
        },
    },
}
</script>