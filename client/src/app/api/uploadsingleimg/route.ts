import { writeFile } from 'fs/promises'
import { NextRequest, NextResponse } from 'next/server'
import { join } from 'path'


export async function POST(request: NextRequest){
    const data = await request.formData()
    
    const file: File | null = data.get('filename') as unknown as File

    if(!file){
        return NextResponse.json({success: false, message: 'File not found', error: 'File not found'})
    }

    const bytes = await file.arrayBuffer()
    
    const buffer = Buffer.from(bytes);
    
    const path = join(process.cwd(), '/public/images/uploaded/', file.name)
    
    writeFile(path, buffer)
    
    return NextResponse.json({
        success: true,
        size: buffer,
        type: file.type,
        local: path,
        url: `/public/images/uploaded/${file.name}`,
        filename: file.name,
        message: "Buffer was successfully uploaded"
    })
}

