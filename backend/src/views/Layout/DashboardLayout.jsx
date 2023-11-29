/* eslint-disable prettier/prettier */
import React, { useContext } from 'react';
import { Outlet } from 'react-router-dom';
import { AuthContext } from 'src/Provider/AuthProvider';
import { AppFooter, AppHeader, AppSidebar } from 'src/components';

const DashboardLayout = () => {
    return (
        <div>
            <AppSidebar />
            <div className="wrapper d-flex flex-column min-vh-100 bg-light">
                <AppHeader />
                <div className="body flex-grow-1 px-3">
                    <Outlet />
                </div>
                <AppFooter />
            </div>
            
        </div>
    );
};

export default DashboardLayout;