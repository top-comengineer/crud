<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header" style="display:flex; justify-content: space-between; ">
            <h3>User Panel</h3>
            <div>
              <a href="#" class="btn btn-primary" @click="importCSV()">Import</a> &nbsp;
              <a href="#" class="btn btn-secondary" @click="exportCSV()">Export</a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user, index) in users" :key="user.id">
                    <td scope="row">{{ index + 1 }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td><a href="#" class="btn btn-warning"
                        @click="get_user(user.id, user.name, user.email)">Edit</a>&nbsp;
                      <a href="#" class="btn btn-danger" @click="delete_user(user.id)">Delete</a>
                    </td>

                  </tr>
                </tbody>
              </table>
              <div class="col-md-12" v-if="edituser">
                <h2>Edit User</h2>
                <form v-on:submit.prevent="update(upd_user.id)">
                  <div class="form-group">
                    <label for="name">Enter name</label>
                    <input type="text" name=" name" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp" placeholder="Enter Username" v-model="upd_user.name">
                  </div>
                  <div class="form-group">
                    <label for="email">Enter Email</label>
                    <input type="email" name=" email" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp" placeholder="Enter Email" v-model="upd_user.email">
                    <input type="hidden" name="id" v-model="upd_user.id">
                  </div>


                  <button type="submit" class="btn btn-primary">Update</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from 'axios'
export default {
  name: "dashboard",
  mounted() {
    //getting user data
    this.loadlist();
  },
  data() {
    return {
      user: this.$store.state.auth.user,
      users: [],      //user array
      index: 1,
      posts: [],
      edituser: false,
      adduser: true,
      form: {
        name: '',
        email: ''

      },
      upd_user: {
        id: null,
        name: '',
        email: '',
      },
    }
  },
  methods: {

    importCSV() {

    },

    exportCSV() {

    },

    //getting all users 
    loadlist() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.get('/api/users/read')
          .then(response => {
            this.users = response.data;
          })
          .catch(function (error) {
            console.error(error);
          });
      })
    },

    //add new user
    create_user() {
      axios
        .post('/create', this.form)
        .then((resp) => {
          this.loadlist();
          //reset form
          this.form.name = '';
          this.form.email = '';
        })
        .catch((e) => {
          console.log(e);
        })
    },
    //get user dtails to show inside edit form
    get_user(id, name, email) {
      this.edituser = true;
      this.adduser = false
      this.upd_user.id = id;
      this.upd_user.name = name;
      this.upd_user.email = email;
    },
    //update user
    update(id) {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios
          .post('api/users/update/' + id, this.upd_user)
          .then((resp) => {
            this.edituser = false;
            this.adduser = true
            this.loadlist();
          })
          .catch((e) => {
            console.log(e);
          })
      })
    },
    //delete user
    delete_user(deleteid) {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.delete('api/users/delete/' + deleteid)
          .then((res) => {
            this.loadlist();
          })
          .catch((e) => {
            console.log(e);
          })
      })
    }
  },
}
</script>