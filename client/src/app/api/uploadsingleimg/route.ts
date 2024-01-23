import { writeFile } from 'fs/promises'
import { NextRequest, NextResponse } from 'next/server'
import { join } from 'path'

console.log('Hit File Upload Tsx')
export async function POST(request: NextRequest){
    const data = await request.formData()
    
    const file: File | null = data.get('filename') as unknown as File

    console.log('Ayo file?', file)

    // Ayo file? File {
    //     size: 2876258,
    //     type: 'image/jpeg',
    //     name: '20170810_213222.jpg',
    //     lastModified: 1705969534170

    if(!file){
        return NextResponse.json({success: false, message: 'File not found', error: 'File not found'})
    }

    const bytes = await file.arrayBuffer()
    console.log('Ayo bytes?', bytes)
    const buffer = Buffer.from(bytes);
    console.log('Ayo buffer?', buffer)
    // With the file data in the buffer,ou can do whaterverou want to do with it.
    //  For this, we will just write it to the file system in a new location

    const path = join(process.cwd(), '/public/images/uploaded/', file.name)
    console.log('Ayo path?', path)
    writeFile(path, buffer)

    console.log(`open ${path} to see the uploaded file`)

    //return Response.json({path})

    //return NextResponse.json({path})
    
    return NextResponse.json({
        success: true,
        size: bytes,
        type: file.type,
        local: path,
        url: join('\/public\/images\/uploaded\/', file.name),
        filename: file.name,
        message: "Buffer was successfully uploaded"
    })
}

