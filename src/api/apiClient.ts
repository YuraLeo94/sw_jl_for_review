import axios from "axios";
import { BASE_URL2 } from "./ProductsService";
import { IexecResInfo, IProduct, IReviceProductsResponse } from "../utils/types/global";

const apiClient = axios.create({
    baseURL: BASE_URL2,
    headers: {
        "Content-type": "application/json",
    },
});


const getAllProducts = async () => {
    const res = await apiClient.get<IReviceProductsResponse>('/products/get');
    console.log('REsponse DATA ', res.data);
    return res.data;
}

const addProduct = async (product: IProduct) => {
    const res = await apiClient.post<any>('/products/add', { ...product });
    return res.data;
}

const deleteByIds = async (ids: string[]) => {
    const response = await apiClient.delete<any>('/products/delete', { data: { ...ids } });
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