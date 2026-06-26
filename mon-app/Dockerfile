# ========== ÉTAPE 1 : BUILD ==========
FROM node:20-alpine AS builder

WORKDIR /app

# On copie package.json en premier (cache des layers)
COPY package*.json ./

# On installe TOUTES les dépendances (y compris devDependencies)
RUN npm install

# On copie le reste du code source
COPY src/ ./src/

# ========== ÉTAPE 2 : PRODUCTION ==========
FROM node:20-alpine AS production

# Utilisateur non-root (sécurité)
RUN addgroup -S appgroup && adduser -S appuser -G appgroup

WORKDIR /app

# On copie uniquement ce dont on a besoin depuis l'étape builder
COPY --from=builder /app/node_modules ./node_modules
COPY --from=builder /app/src ./src
COPY --from=builder /app/package.json ./

# On bascule vers l'utilisateur non-root
USER appuser

EXPOSE 3000

CMD ["node", "src/index.js"]