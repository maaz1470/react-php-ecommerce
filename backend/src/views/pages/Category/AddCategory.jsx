/* eslint-disable prettier/prettier */
import { CButton, CCard, CCardBody, CCardHeader, CCol, CFormInput, CFormSelect, CInputGroup, CInputGroupText, CRow } from '@coreui/react';
import axios from 'axios';
import React, { useState } from 'react';

const AddCategory = () => {

    const [category, setCategory] = useState({
        name: '',
        status: 0
    });

    const handleChange = (e) => {
        setCategory({
            ...category,
            [e.target.name]: e.target.value
        })
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = new FormData();
        for(const i in category){
            formData.append(i,category[i]);
        }
        axios.post('/category/add',formData).then(response => {
            console.log(response)
        });
    }


    return (
        <div>
            <CRow>
                <CCol xs={12}>
                    <CCard className="mb-4">
                    <CCardHeader>
                        <strong>Add Category</strong>
                    </CCardHeader>
                    <form action="" onSubmit={handleSubmit}>
                        <CCardBody>
                            <CInputGroup className="mb-3">
                                <CInputGroupText id="basic-addon1">@</CInputGroupText>
                                <CFormInput
                                onChange={handleChange}
                                value={category.name}
                                name='name'
                                placeholder="Category Name"
                                aria-describedby="basic-addon1"
                                />
                            </CInputGroup>
                            <CInputGroup className='mb-3'>
                                <CInputGroupText id="basic-addon2">@</CInputGroupText>
                                <CFormSelect onChange={handleChange} value={category.value} name='status' aria-label="Default select example">
                                    <option value="1">Published</option>
                                    <option value="0">Unpublished</option>
                                </CFormSelect>
                            </CInputGroup>
                            <CInputGroup className='mb-3'>
                                <CButton color='primary' type='submit'>Add Category</CButton>
                            </CInputGroup>
                        </CCardBody>
                    </form>
                    </CCard>
                </CCol>
            </CRow>
        </div>
    );
};

export default AddCategory;