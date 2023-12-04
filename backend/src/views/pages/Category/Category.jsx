/* eslint-disable prettier/prettier */
import React from 'react'
import {
    CButton,
  CCard,
  CCardBody,
  CCardHeader,
  CCol,
  CInputGroup,
  CRow,
} from '@coreui/react'
import { Link } from 'react-router-dom'
// import { DocsExample } from 'src/components'

const Category = () => {
  return (
        <CRow>
            <CCol xs={12}>
                <CCard className="mb-4">
                    <CCardHeader style={{display: 'flex',justifyContent: 'space-between', alignItems: 'center'}}>
                        <div>
                        <strong>All Categories</strong>
                        </div>
                        <div style={{display: 'flex', alignItems: 'center'}}>
                            <CInputGroup className='mb-3'>
                                <CButton color='primary' active={'active'}>
                                    <Link to={'/categories/add'} style={{color: '#fff', textDecoration: 'none'}}>Add Category</Link>
                                </CButton>
                            </CInputGroup>
                        </div>
                    </CCardHeader>
                    <CCardBody>
                        <table className='table'>
                            <thead>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                                <th>Name</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                </tr>
                                <tr>
                                    <td>#</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                </tr>
                                <tr>
                                    <td>#</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                    <td>Something</td>
                                </tr>
                            </tbody>
                        </table>
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
  )
}

export default Category
