This is a [Next.js](https://nextjs.org/) project bootstrapped with [`create-next-app`](https://github.com/vercel/next.js/tree/canary/packages/create-next-app).

## Getting Started

First, run the development server:

```bash
npm run dev
# or
yarn dev
# or
pnpm dev
# or
bun dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result.

You can start editing the page by modifying `app/page.tsx`. The page auto-updates as you edit the file.

This project uses [`next/font`](https://nextjs.org/docs/basic-features/font-optimization) to automatically optimize and load Inter, a custom Google Font.

## Learn More

To learn more about Next.js, take a look at the following resources:

- [Next.js Documentation](https://nextjs.org/docs) - learn about Next.js features and API.
- [Learn Next.js](https://nextjs.org/learn) - an interactive Next.js tutorial.

You can check out [the Next.js GitHub repository](https://github.com/vercel/next.js/) - your feedback and contributions are welcome!

## Deploy on Vercel

The easiest way to deploy your Next.js app is to use the [Vercel Platform](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app-readme) from the creators of Next.js.

Check out our [Next.js deployment documentation](https://nextjs.org/docs/deployment) for more details.



### shadcn/ui

This project uses tailwindcss and shadcn/ui for reusable components for this project.

Home Page
    [ui.shadcn.com/](https://ui.shadcn.com/)

Important links to components are as follows

-Button
    [ui.shadcn.com - Button](https://ui.shadcn.com/docs/components/button)


## Prisma

You can do as many push you want to the database but once you have the database the way you want it, and it's responding corrrectly.

Then you run this command only.

```sh
    npx prisma db push
```

After chaning a model in the again, you must migrate reset, prisma migrate genearte and primsa db push as follows:

```sh

    npx prisma migrate dev

    npx prisma migrate generate

    npx primsa 

```
```sh

    npx prisma migrate reset

    npx prisma migrate generate

    npx primsa 

```

## Prisma Studio

This is how you run prisma studio from client directory.

```sh
    npx prisma studio
```


## For Development There is seed data for users

This file takes seed.js and runs users.js for seeder file.

```sh
    yarn seed
```


## Kurento Development

https://github.com/kurento


Perferably to pull kurento a docker image and bridge the network on local and in production.

## Kurento Docker Image

Kurento Landing Page since Twillo Bought Them Out.
    https://kurento.openvidu.io/documentation

The Docker Image For Kurento
    https://hub.docker.com/r/kurento/kurento-media-server

Installation of Kurento And How to Install IT
    https://doc-kurento.readthedocs.io/en/latest/user/installation.html


Reference Points Of Tutorials With Kurento
    https://doc-kurento.readthedocs.io/en/latest/user/tutorials.html


```sh
        docker pull kurento/kurento-media-server
```


```sh
    curl \
        --include \
        --header "Connection: Upgrade" \
        --header "Upgrade: websocket" \
        --header "Host: 127.0.0.1:8888" \
        --header "Origin: 127.0.0.1" \
        "http://127.0.0.1:8888/kurento"
```
