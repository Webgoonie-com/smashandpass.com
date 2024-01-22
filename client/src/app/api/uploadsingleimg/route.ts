import { writeFile } from 'fs/promises'
import { NextRequest, NextResponse } from 'next/server'
import { join } from 'path'


export async function POST(request: NextRequest){
    const data = await request.formData()
    const file: File | null = data.get('file') as unknown as File

    if(!file){
        return NextResponse.json({success: false, message: 'File not found', error: 'File not found'})
    }

    const bytes = await file.arrayBuffer()

    const buffer = Buffer.from(bytes);

    // With the file data in the buffer,ou can do whaterverou want to do with it.
    //  For this, we will just write it to the file system in a new location

    const path = join('/', 'tmp', file.name)

    writeFile(path, buffer)

    console.log(`open ${path} to see the uploaded file`)

    return NextResponse.json({success: true, message: "Buffer was successfully uploaded"})
}

