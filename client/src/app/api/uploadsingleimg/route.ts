import { writeFile } from 'fs/promises';
import { NextRequest, NextResponse } from 'next/server';
import { join } from 'path';
import {PrismaOrm} from "@/lib/prismaOrm";
import { CurrentProfile } from '@/lib/currentProfile';

export async function POST(request: NextRequest) {
  const data = await request.formData();
  
  const file: File | null = data.get('filename') as unknown as File;

  if (!file) {
    return NextResponse.json({ success: false, message: 'File not found', error: 'File not found' });
  }

  const bytes = await file.arrayBuffer();
  const buffer = Buffer.from(bytes);
  const path = join(process.cwd(), '/public/images/uploaded/', file.name);

  // Now Log To Database
  try {
    const profile = await CurrentProfile();
    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const createPhoto = await PrismaOrm.userPhoto.create({
      data: {
        serverCaption: 'Single Image',
        imageSize: buffer.length,
        type: file.type,
        local: path,
        url: `/public/images/uploaded/${file.name}`,
        filename: file.name,
        message: "Buffer was successfully uploaded",
        //userId: profile.Id,
        user: {
            connect: { id: profile.Id }, // Connect to the user by ID
          },
      },
    });

    writeFile(path, buffer);
    
    return NextResponse.json({
        success: true,
        size: buffer.length,
        type: file.type,
        local: path,
        url: `/public/images/uploaded/${file.name}`,
        filename: file.name,
        message: "Buffer was successfully uploaded",
      }, createPhoto);

  } catch (error) {
    // Handle the error appropriately
    console.error(error);
    return NextResponse.json({ success: false, message: 'Error uploading file' });
  }

  

  
}
