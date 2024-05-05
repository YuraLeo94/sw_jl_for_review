import axios from "axios";
import { API_URL, API_URL2 } from "./ProductsService";
import { IProduct, IReviceProductsResponse } from "../utils/types/global";
import { API } from "../utils/types/api.const";

const apiClient = axios.create({
    baseURL: API_URL,
    // baseURL: process.env.REACT_APP_API_BASE_URL,
    headers: {
        "Content-type": "application/json",
    },
});

const apiClient2 = axios.create({
    baseURL: API_URL,
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

const addProduct = async (product: IProduct) => {
    const res = await apiClient.post<any>(API.add, { ...product });
    return res.data;
}

const deleteByIds = async (ids: string[]) => {
    const response = await apiClient.delete<any>(API.delete, { data: { ...ids } });
    return response.data;
};

//invalid type
const addProductType = async (product: IProduct) => {
    const res = await apiClient.post<any>('/products/add', {} as IProduct);
    return res.data;
}


const addProduct3 = async (product: IProduct) => {
    const res = await apiClient.post<IProduct, any>('/products/add', { ...product });
    return res.data;
}

const addProduct2 = async (product: IProduct) => {
    console.log('addProduct Data', product);
    const res = await apiClient.post<IProduct, any>('/products/add', { ...product });
    console.log('REsponse DATA ', res.data);
    return res.data;
}

const ProductsService = {
    getAllProducts,
    addProduct,
    deleteByIds
};

export default ProductsService;