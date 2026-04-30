# SystemVote Use Case Diagram - Quick Reference

## 📊 Diagram Summary

**System**: SystemVote - Real-time Voting Platform
**Format**: draw.io XML
**File**: `usecase-diagram-main.drawio`

---

## 👥 Actors (4 Total)

| Actor | Role | Key Actions |
|-------|------|------------|
| **Guest** | Unauthenticated user | Register, Login |
| **Registered User** | Authenticated user | Create rooms, Join rooms, Manage account |
| **Room Owner** | Room creator | Full room/topic management, Member approval, Admin panel |
| **Participant** | Room member | Join, Vote, View results, Leave |

---

## 🎯 Use Cases (23 Total)

### Authentication (3)
- Register Account
- Login
- Request Password Reset

### Room Management (5)
- Create Room
- View My Rooms
- Edit Room
- Delete Room
- Start Room

### Topic Management (5)
- Create Topic
- Edit Topic
- Delete Topic
- Start Topic
- Stop Topic

### Participation (4)
- Join Room
- Enter Username
- Wait for Approval
- Leave Room

### Voting (3)
- Cast Vote
- View Live Results
- View Vote Statistics

### Admin (3)
- View Admin Panel
- Approve Member
- Remove Member

---

## 🔗 Key Relationships

### Include (Mandatory)
```
Join Room ──include──> Enter Username
Cast Vote ──include──> View Live Results
Start Topic ──include──> Start Room
```

### Extend (Conditional)
```
Enter Username ──extend──> Wait for Approval
(Only for private rooms)
```

---

## 📋 Actor Capabilities Matrix

| Capability | Guest | User | Owner | Participant |
|-----------|-------|------|-------|-------------|
| Register | ✅ | - | - | - |
| Login | ✅ | ✅ | ✅ | ✅ |
| Create Room | - | ✅ | ✅ | - |
| Manage Room | - | - | ✅ | - |
| Create Topic | - | - | ✅ | - |
| Join Room | - | ✅ | - | ✅ |
| Cast Vote | - | - | - | ✅ |
| View Results | - | - | ✅ | ✅ |
| Approve Members | - | - | ✅ | - |

---

## 🎨 Design Principles Applied

✅ **Clarity**: Clear verb-based naming, logical grouping
✅ **Completeness**: All 23 use cases from source code included
✅ **Consistency**: Naming follows domain language
✅ **Scalability**: Organized by functional domains
✅ **Maintainability**: Well-documented relationships
✅ **Professional**: Production-ready UML standard

---

## 📝 How to Use This Diagram

### For Development
- Reference during sprint planning
- Validate feature implementations
- Identify missing functionality

### For Documentation
- Include in technical specifications
- Share with stakeholders
- Use in architecture reviews

### For Testing
- Map test cases to use cases
- Ensure all paths are covered
- Validate actor permissions

---

## 🔄 Typical User Flows

### Flow 1: Room Owner Setup
```
1. Register Account
2. Login
3. Create Room
4. Create Topic(s)
5. Start Room
6. Start Topic
7. View Admin Panel
8. Approve Members
9. Stop Topic
10. View Vote Statistics
```

### Flow 2: Participant Voting
```
1. Register Account (if new)
2. Login
3. Join Room (using code)
4. Enter Username
5. Wait for Approval (if private room)
6. Cast Vote
7. View Live Results
8. Leave Room
```

### Flow 3: Account Recovery
```
1. Login (forgot password)
2. Request Password Reset
3. Check email for link
4. Verify link
5. Login with new password
```

---

## 🚀 Implementation Status

| Use Case | Status | Controller | Route |
|----------|--------|-----------|-------|
| Register Account | ✅ | AuthController | POST /register |
| Login | ✅ | AuthController | POST /login |
| Create Room | ✅ | RoomController | POST /createroom |
| Join Room | ✅ | JoinController | POST /rooms/join |
| Cast Vote | ✅ | VoteController | POST /rooms/vote/submit |
| Start Topic | ✅ | TopicController | POST /rooms/{room}/topic/{topic}/start |
| View Admin Panel | ✅ | AdminController | GET /rooms/{room}/admin |

---

## 📌 Important Notes

1. **Real-time Updates**: WebSocket (Reverb) broadcasts vote updates
2. **Room Codes**: 6-digit numeric format for easy sharing
3. **Private Rooms**: Require owner approval before voting
4. **Vote Immutability**: Votes cannot be changed once cast
5. **Single Active Topic**: Only one topic can be voted on at a time

---

## 📞 Support

For questions about this diagram:
- Review `USECASE_DIAGRAM_DOCUMENTATION.md` for detailed explanations
- Check source code in `app/Http/Controllers/`
- Refer to routes in `routes/web.php`

---

**Version**: 1.0
**Created**: 2025
**Format**: UML 2.5 Standard
