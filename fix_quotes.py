def fix():
    path = 'resources/views/home/index.blade.php'
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Replace escaped quotes inside asset
    content = content.replace(r"\'", "'")
    
    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)

fix()
