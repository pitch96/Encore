//
//  EventListModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 15/04/23.
//

import Foundation
// MARK: - Event list Model
struct EventListModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [ListDetails]?
}

// MARK: - Event list Details
struct ListDetails: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
// MARK: - Category list Model
struct CategoryLisModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [CategoryListDetails]?
}

// MARK: - Category list Model Details
struct CategoryListDetails: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
