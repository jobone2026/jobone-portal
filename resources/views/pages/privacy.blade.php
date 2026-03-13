@extends('layouts.app')

@section('title', 'Privacy Policy - JobOne.in')
@section('description', 'Privacy Policy for JobOne.in')

@section('content')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    <div class="glass-effect rounded-lg shadow-md p-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Privacy Policy</h1>
        
        <div class="prose prose-lg max-w-none text-gray-700">
            <p class="mb-4">
                <strong>Last Updated:</strong> March 2026
            </p>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">1. Introduction</h2>
            <p class="mb-4">
                JobOne.in ("we", "us", "our", or "Company") operates the jobone.in website. This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.
            </p>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">2. Information Collection and Use</h2>
            <p class="mb-4">
                We collect several different types of information for various purposes to provide and improve our Service to you.
            </p>
            <ul class="list-disc list-inside mb-4 space-y-2">
                <li>Personal Data: Name, email address, phone number</li>
                <li>Usage Data: Browser type, IP address, pages visited</li>
                <li>Cookies and tracking technologies</li>
            </ul>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">3. Use of Data</h2>
            <p class="mb-4">
                JobOne.in uses the collected data for various purposes:
            </p>
            <ul class="list-disc list-inside mb-4 space-y-2">
                <li>To provide and maintain our Service</li>
                <li>To notify you about changes to our Service</li>
                <li>To allow you to participate in interactive features</li>
                <li>To provide customer support</li>
                <li>To gather analysis or valuable information</li>
                <li>To monitor the usage of our Service</li>
            </ul>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">4. Security of Data</h2>
            <p class="mb-4">
                The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.
            </p>
            
            <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">5. Contact Us</h2>
            <p class="mb-4">
                If you have any questions about this Privacy Policy, please contact us at:
            </p>
            <p class="mb-4">
                Email: <a href="mailto:jobone2026@gmail.com" class="text-red-600 hover:text-red-700 font-semibold">jobone2026@gmail.com</a>
            </p>
        </div>
    </div>
@endsection
