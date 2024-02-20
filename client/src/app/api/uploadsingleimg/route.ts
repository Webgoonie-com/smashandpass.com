import { writeFile, mkdir } from 'fs/promises';
import { NextRequest, NextResponse } from 'next/server';
import { join, dirname } from 'path';
import { PrismaOrm } from "@/lib/prismaOrm";
import { CurrentProfile } from '@/lib/currentProfile';

console.log('Hit Upload single img');

async function ensureDirectoryExistence(filePath: string) {
  const directory = dirname(filePath);
  try {
    await mkdir(directory, { recursive: true });
  } catch (error: any) {
    if (error.code !== 'EEXIST') {
      throw error;
    }
  }
}

export async function POST(request: NextRequest) {
  const data = await request.formData();

  const file: File | null = data.get('filename') as unknown as File;

  if (!file) {
    return NextResponse.json({ success: false, message: 'File not found', error: 'File not found' });
  }

  const bytes = await file.arrayBuffer();
  const buffer = Buffer.from(bytes);

  try {
    const profile = await CurrentProfile();
    if (!profile) {
      console.log('No Profile So Failed.');
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const imageUrl = process.env.NEXT_PUBLIC_IMAGE_URL || "/images/";
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');

    const outputPath = join(process.cwd(), `/public/images/uploaded/${year}/${month}/${day}/${profile.Id}/`, file.name);
    
    await ensureDirectoryExistence(outputPath);

    const createPhoto = await PrismaOrm.userPhoto.create({
      data: {
        serverCaption: 'Single Image',
        imageSize: buffer.length,
        type: file.type,
        local: outputPath,
        url: `${imageUrl}uploaded/${year}/${month}/${day}/${profile.Id}/${file.name}`,
        filename: file.name,
        message: "Buffer was successfully uploaded",
        user: {
          connect: { id: profile.Id },
        },
      },
    });

    await writeFile(outputPath, buffer);

    return NextResponse.json({
      success: true,
      size: buffer.length,
      type: file.type,
      local: outputPath,
      url: `${imageUrl}uploaded/${year}/${month}/${day}/${profile.Id}/${file.name}`,
      filename: file.name,
      message: "Buffer was successfully uploaded",
    }, createPhoto);

  } catch (error) {
    console.error(error);
    return NextResponse.json({ success: false, message: 'Error uploading file' });
  }
}
