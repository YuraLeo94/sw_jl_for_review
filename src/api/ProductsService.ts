const BASE_URL = 'http://localhost:3000';
export const BASE_URL2 =  'http://localhost/projects/SW/backend';
const ProductService = {
    async getTodos() {
      const response = await fetch(`${BASE_URL2}/products/get`);
      console.log('Response', response);
     const data = await response.json();
     console.log('data', data);
     return data;
    },
  
    // async addTodo(title) {
    //   const response = await fetch(`${BASE_URL}/todos`, {
    //     method: 'POST',
    //     headers: {
    //       'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify({ title }),
    //   });
    //   return await response.json();
    // },
  
    // async toggleComplete(id) {
    //   await fetch(`${BASE_URL}/todos/${id}`, {
    //     method: 'PUT',
    //   });
    // },
  
    // async deleteTodo(id) {
    //   await fetch(`${BASE_URL}/todos/${id}`, {
    //     method: 'DELETE',
    //   });
    // },
  };
  
  export default ProductService;