import re

def fix():
    path = 'resources/views/home/index.blade.php'
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Replace top section
    content = re.sub(r'<!DOCTYPE html>.*?(<section class=\"hero\">)', r"@extends('layouts.public')\n\n@section('content')\n\n    \1", content, flags=re.DOTALL)
    
    # Replace bottom section
    content = re.sub(r'<script src=\"script\.js\"></script>.*', r'@endsection\n', content, flags=re.DOTALL)
    
    # Fix image links
    content = re.sub(r'src=\"images/([^\"]+)\"', r'src="{{ asset(\'images/\1\') }}"', content)
    
    # Fix video links
    content = re.sub(r'src=\"images/([^\"]+\.mp4)\"', r'src="{{ asset(\'images/\1\') }}"', content)
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

fix()
