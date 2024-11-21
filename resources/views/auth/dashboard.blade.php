@extends('layouts.app')

@section('title', 'Login')

@section('content')
    {{ $token = session('token'); }}
    {{ dd($token); }}
    <div class="flex flex-col items-center justify-center mt-6">
        <table class="table-auto  shadow-2xl border-2 border-cyan-800 w-6/12" id="contacts">
            <thead>
                <tr>
                    <th class="text-start px-4 py-2">Name</th>
                    <th class="text-start px-4 py-2">Company</th>
                    <th class="text-start px-4 py-2">Phone</th>
                    <th class="text-start px-4 py-2">Email</th>
                    <th class="text-start px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <div id="pagination-controls" class="mt-4 flex justify-center space-x-2"></div>
    </div>
    <script>
        let fetchUsers, editButton, deleteButton;
        $(document).ready(function() {
            const url = '/api/users'
            const token = localStorage.getItem('token')
            fetchUsers = function(page = 1) {
                $.ajax({
                    url: `${url}?page=${page}`,
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`, // Add the token to the Authorization header
                        'Content-Type': 'application/json',
                    },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $("#contacts tbody");
                        const paginationControls = $("#pagination-controls");

                        tableBody.empty(); // Clear any existing rows

                        data.data.forEach((item, index) => {
                            const rowClass = index % 2 === 0 ? "bg-gray-100" :
                                "bg-gray-300"; // Alternating row colors
                            const row = `
                                <tr class="${rowClass}">
                                    <td class="px-4 py-2">${item.attributes.name}</td>
                                    <td class="px-4 py-2">${item.attributes.company}</td>
                                    <td class="px-4 py-2">${item.attributes.contact_no}</td>
                                    <td class="px-4 py-2">${item.attributes.email}</td>
                                    <td class="px-4 py-2 flex">
                                        ${item.actions.edit ? '<button class="px-3 py-1 mr-2 bg-blue-500 text-white rounded" onclick=editButton()>Edit</button>' : ''}
                                        ${item.actions.delete ? '<button class="px-3 py-1 bg-red-500 text-white rounded" onclick=deleteButton()>Delete</button>' : ''}
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });

                        // Handle pagination links
                        const meta = data.meta; // Metadata for pagination
                        const links = data.links; // Links for navigation
                        paginationControls.empty(); // Clear existing controls
                        // Create Previous button
                        if (links.prev) {
                            paginationControls.append(`
                                <button class="px-3 py-2 bg-cyan-700 text-white rounded" onclick="fetchUsers(${meta.current_page - 1})">
                                    Previous
                                </button>
                            `);
                        }

                        // Create page number buttons
                        const totalPages = meta.last_page;
                        for (let i = 1; i <= totalPages; i++) {
                            console.log(i === meta.current_page)
                            paginationControls.append(`
                                <button class="px-3 py-2 bg-gray-200 text-black rounded mx-1 ${i === meta.current_page ? 'bg-gray-400 font-bold' : ''}" onclick="fetchUsers(${i})">
                                    ${i}
                                </button>
                            `);
                        }

                        // Create Next button
                        if (links.next) {
                            paginationControls.append(`
                                <button class="px-3 py-2 bg-cyan-700 text-white rounded" onclick="fetchUsers(${meta.current_page + 1})">
                                    Next
                                </button>
                            `);
                        }

                    },
                    error: function(error) {
                        console.error("Error fetching users:", error);
                    }
                })
            }

            editButton = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Do you want to continue',
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
            }

            deleteButton = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Do you want to continue',
                    icon: 'error',
                    confirmButtonText: 'Cool'
                })
            }

            // Initial fetch
            fetchUsers();
        })
    </script>
@endsection
