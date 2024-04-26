import { Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { dummyProductsData } from './dummyData';
import { useState } from 'react';
import names from '../../utils/types/dictionary.consts';
import { route } from '../../utils/types/global';

function ProductList(): JSX.Element {
    const navigate = useNavigate();
    const [selectedItems, setSelectedItems] = useState<string[]>([]);

    const onAdd = () => {
        navigate(route.ADD_PRODUCT);
    }

    const onDelete = () => {
        console.log('Delete: ', selectedItems);
    }

    const handleCheckboxChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { value, checked } = event.target;
        if (checked) {
            setSelectedItems([...selectedItems, value]);
        } else {
            setSelectedItems(selectedItems.filter(item => item !== value));
        }
    };

    return (
        <>
            <div className='product-list-container flex-grow-1'>
                <div className='product-list-header border-bottom border-dark pb-3 pt-5'>
                    <div className='title'><h1>{names.PRODCUT_LIST_TITLE}</h1></div>
                    <div className='action-buttons-container'>
                        <Button className='sw-button' variant="light" onClick={onAdd}>{names.PRODCUT_LIST_ADD_BUTTON}</Button>
                        <Button className='sw-button' variant="light" id='delete-product-btn' onClick={onDelete}>{names.PRODCUT_LIST_DELETE_BUTTON}</Button>
                    </div>
                </div>
                <div className='product-items-container py-5 px-3 d-flex flex-fill flex-row flex-wrap'>
                    {dummyProductsData.map((product) => (
                        <div key={product.SKU} className='product-item d-flex p-3 border border-dark '>
                            <div>
                                <label className="sw-checkbox delete-checkbox">
                                    <input
                                        type="checkbox"
                                        value={product.SKU}
                                        onChange={handleCheckboxChange}
                                    />
                                    <span className="checkmark"></span>
                                </label>
                            </div>
                            <div className='d-flex flex-column mt-3 align-items-center w-100'>
                                <div>{product.SKU}</div>
                                <div>{product.name}</div>
                                <div>{product.price.toFixed(2)} $</div>
                                {product?.sizeMB && <div>{names.PRODCUT_LIST_SIZE_TEXT.replace('{sizeMB}', product.sizeMB.toString())}</div>}
                                {product?.weightKg && <div>{names.PRODCUT_LIST_WEIGHT_TEXT.replace('{weightKg}', product.weightKg.toString())}</div>}
                                {product?.dimensions && <div>{names.PRODCUT_LIST_DIMENSION_TEXT} {product?.dimensions}</div>}
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}

export default ProductList;