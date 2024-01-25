/*
  Warnings:

  - The primary key for the `channel` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `channel` table. All the data in the column will be lost.
  - You are about to alter the column `serverId` on the `channel` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - The primary key for the `conversation` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `conversation` table. All the data in the column will be lost.
  - You are about to alter the column `memberOneId` on the `conversation` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - You are about to alter the column `memberTwoId` on the `conversation` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - The primary key for the `directmessage` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `directmessage` table. All the data in the column will be lost.
  - You are about to alter the column `memberId` on the `directmessage` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - You are about to alter the column `conversationId` on the `directmessage` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - The primary key for the `member` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `member` table. All the data in the column will be lost.
  - You are about to alter the column `serverId` on the `member` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - The primary key for the `message` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `message` table. All the data in the column will be lost.
  - You are about to alter the column `memberId` on the `message` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - You are about to alter the column `channelId` on the `message` table. The data in that column could be lost. The data in that column will be cast from `VarChar(191)` to `Int`.
  - The primary key for the `server` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `id` on the `server` table. All the data in the column will be lost.
  - A unique constraint covering the columns `[userId]` on the table `Favorite` will be added. If there are existing duplicate values, this will fail.
  - A unique constraint covering the columns `[authorId]` on the table `Post` will be added. If there are existing duplicate values, this will fail.
  - A unique constraint covering the columns `[userId]` on the table `Reservation` will be added. If there are existing duplicate values, this will fail.
  - A unique constraint covering the columns `[listingId]` on the table `Reservation` will be added. If there are existing duplicate values, this will fail.
  - A unique constraint covering the columns `[uuid]` on the table `Server` will be added. If there are existing duplicate values, this will fail.
  - Added the required column `_Id` to the `Channel` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Channel` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `_Id` to the `Conversation` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Conversation` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `_Id` to the `DirectMessage` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `DirectMessage` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - The required column `uuid` was added to the `Listing` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `_Id` to the `Member` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Member` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `_Id` to the `Message` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Message` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `name` to the `Profile` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Reservation` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.
  - Added the required column `_Id` to the `Server` table without a default value. This is not possible if the table is not empty.
  - The required column `uuid` was added to the `Server` table with a prisma-level default value. This is not possible if the table is not empty. Please add this column as optional, then populate it before making it required.

*/
-- AlterTable
ALTER TABLE `channel` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    MODIFY `serverId` INTEGER NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- AlterTable
ALTER TABLE `conversation` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    MODIFY `memberOneId` INTEGER NOT NULL,
    MODIFY `memberTwoId` INTEGER NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- AlterTable
ALTER TABLE `directmessage` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    MODIFY `memberId` INTEGER NOT NULL,
    MODIFY `conversationId` INTEGER NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- AlterTable
ALTER TABLE `listing` ADD COLUMN `uuid` VARCHAR(191) NOT NULL;

-- AlterTable
ALTER TABLE `member` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    MODIFY `serverId` INTEGER NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- AlterTable
ALTER TABLE `message` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    MODIFY `memberId` INTEGER NOT NULL,
    MODIFY `channelId` INTEGER NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- AlterTable
ALTER TABLE `profile` ADD COLUMN `name` VARCHAR(191) NOT NULL;

-- AlterTable
ALTER TABLE `reservation` ADD COLUMN `uuid` VARCHAR(191) NOT NULL;

-- AlterTable
ALTER TABLE `server` DROP PRIMARY KEY,
    DROP COLUMN `id`,
    ADD COLUMN `_Id` INTEGER NOT NULL AUTO_INCREMENT,
    ADD COLUMN `uuid` VARCHAR(191) NOT NULL,
    ADD PRIMARY KEY (`_Id`);

-- CreateTable
CREATE TABLE `ActivateToken` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(191) NOT NULL,
    `token` VARCHAR(191) NOT NULL,
    `activatedAt` DATETIME(3) NULL,
    `createdAt` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updatedAt` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `userId` INTEGER NOT NULL,

    UNIQUE INDEX `ActivateToken_token_key`(`token`),
    UNIQUE INDEX `ActivateToken_userId_key`(`userId`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateIndex
CREATE UNIQUE INDEX `Favorite_userId_key` ON `Favorite`(`userId`);

-- CreateIndex
CREATE UNIQUE INDEX `Post_authorId_key` ON `Post`(`authorId`);

-- CreateIndex
CREATE UNIQUE INDEX `Reservation_userId_key` ON `Reservation`(`userId`);

-- CreateIndex
CREATE UNIQUE INDEX `Reservation_listingId_key` ON `Reservation`(`listingId`);

-- CreateIndex
CREATE UNIQUE INDEX `Server_uuid_key` ON `Server`(`uuid`);
