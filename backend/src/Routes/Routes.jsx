/* eslint-disable prettier/prettier */
/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable prettier/prettier */
import DashboardLayout from "src/views/Layout/DashboardLayout";
import ProtectedRoute from "./ProtectedRoute";
import Dashboard from "src/views/dashboard/Dashboard";
import AuthLayout from "src/views/pages/Auth/AuthLayout";
import Login from "src/views/pages/login/Login";
import Register from "src/views/pages/register/Register";
import Category from "src/views/pages/Category/Category";
import CategoryLayout from "src/views/pages/Category/CategoryLayout";
import AddCategory from "src/views/pages/Category/AddCategory";

const { createBrowserRouter, Navigate } = require("react-router-dom");

const router = createBrowserRouter([
    {
        path: '/',
        element: <ProtectedRoute><DashboardLayout /></ProtectedRoute>,
        children: [
            {
                path: '',
                element: <Dashboard />
            },
            {
                path: 'categories',
                element: <CategoryLayout />,
                children: [
                    {
                        path: '',
                        element: <Category />
                    },
                    {
                        path: 'add',
                        element: <AddCategory />
                    }
                ]
            }
        ]
    },
    {
        path: '/auth',
        element: <AuthLayout />,
        children: [
            {
                path: '',
                element: <Navigate to={'/auth/login'} replace />
            },
            {
                path: 'login',
                element: <Login />,
            },
            {
                path: 'register',
                element: <Register />,
            },
        ]
    },
    {
        path: '*',
        element: <h1>404 Error</h1>,
    },
])

export default router;