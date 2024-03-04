//
//  CreateEventModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/02/23.
//

import Foundation
struct CreateEventModel: Codable {
    // MARK: Create Event Model--
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: CreateEventDetail?
}

// MARK: - DataClass
struct CreateEventDetail: Codable {
    var userID: Int?
    var eventTitle, categoryID, organizer, venue: String?
    var address, city, zipcode, startDate: String?
    var endDate, startTime, endTime, description: String?
    var image: String?
    var updatedAt, createdAt: String?
    var id: Int?

    enum CodingKeys: String, CodingKey {
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case description, image
        case updatedAt = "updated_at"
        case createdAt = "created_at"
        case id
    }
}
