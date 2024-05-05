import axios from "axios";
import { ICreateProductResponse, IDeleteProductResponse, IProduct, IReviceProductsResponse } from "../utils/types/global";
import { API } from "../utils/types/api.const";
export const API_URL = 'http://localhost/projects/SW/backend/index.php';
const apiClient = axios.create({
    baseURL: API_URL,
    // baseURL: process.env.REACT_APP_API_BASE_URL,
    headers: {
        "Content-type": "application/json",
    },
});


const getAllProducts = async () => {
    console.log(process.env.REACT_APP_API_BASE_URL);
    const res = await apiClient.get<IReviceProductsResponse>(API.get);
    console.log('Response DATA ', res.data);
    return res.data;
}

const createProduct = async (product: IProduct) => {
    const res = await apiClient.post<IProduct, ICreateProductResponse>(API.add, { ...product });
    return res.data;
}

const deleteByIds = async (ids: string[]) => {
    const response = await apiClient.delete<string[], IDeleteProductResponse>(API.delete, { data: { ...ids } });
    return response.data;
};

const ProductsService = {
    getAllProducts,
    createProduct,
    deleteByIds
};

export default ProductsService;