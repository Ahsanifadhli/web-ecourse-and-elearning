@extends('layouts.front')

@section('title', 'LMS Pro - Kursus Online Terbaik')

@section('content')

    {{-- 1. Hero Section --}}
    @include('front.sections.hero')

    {{-- 2. Stats Bar --}}
    @include('front.sections.stats')

    {{-- 3. Categories --}}
    @include('front.sections.categories')

    {{-- 4. Popular Courses --}}
    {{-- Variable $courses otomatis turun ke include ini --}}
    @include('front.sections.courses')

    {{-- 5. Testimonial & CTA --}}
    @include('front.sections.cta')

@endsection
